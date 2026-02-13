<?php

namespace App\Http\Controllers;

use App\Models\KhqrTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use KHQR\Models\MerchantInfo;
use KHQR\Models\KHQRResponse;

class BillingController extends Controller
{
    public function show(): View
    {
        $currency = strtoupper((string) config('services.bakong.currency', 'USD'));
        $balance = (float) KhqrTransaction::query()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->where('currency', $currency)
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'topup' THEN amount ELSE -amount END), 0) AS balance")
            ->value('balance');

        return view('billing', [
            'brand' => $this->brand(),
            'transactions' => KhqrTransaction::query()
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(20)
                ->get(),
            'balance' => $balance,
            'balanceCurrency' => $currency,
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'in:USD,KHR'],
            'type' => ['required', 'in:topup,withdraw'],
            'bakong_account_id' => ['nullable', 'string', 'max:255'],
        ]);

        $bakong = config('services.bakong');
        $accountId = $validated['type'] === 'topup'
            ? ($bakong['account_id'] ?? null)
            : $validated['bakong_account_id'];

        if (! $accountId) {
            return response()->json(['message' => 'Bakong account ID is required.'], 422);
        }

        $accountInformation = $bakong['account_information'] ?? null;
        $merchantId = $bakong['merchant_id'] ?? null;
        $acquiringBank = $bakong['acquiring_bank'] ?? null;
        if ($merchantId && ! $acquiringBank && str_contains($accountId, '@')) {
            $acquiringBank = strtoupper((string) substr(strrchr($accountId, '@'), 1));
        }

        $merchantName = $validated['type'] === 'topup'
            ? ($bakong['merchant_name'] ?? config('app.name'))
            : ($request->user()?->name ?? 'User');
        $merchantCity = $bakong['merchant_city'] ?? 'PHNOM PENH';
        $currencySetting = strtoupper((string) ($bakong['currency'] ?? 'KHR'));
        $currencySetting = in_array($currencySetting, ['USD', 'KHR'], true) ? $currencySetting : 'KHR';
        $currency = $currencySetting === 'USD' ? KHQRData::CURRENCY_USD : KHQRData::CURRENCY_KHR;

        if ($currencySetting === 'KHR' && floor((float) $validated['amount']) != (float) $validated['amount']) {
            return response()->json(['message' => 'KHR amount must be a whole number.'], 422);
        }

        try {
            if ($merchantId) {
                if (! $acquiringBank) {
                    return response()->json(['message' => 'Acquiring bank is required for merchant KHQR.'], 422);
                }
                $info = new MerchantInfo(
                    bakongAccountID: $accountId,
                    merchantName: $merchantName,
                    merchantCity: $merchantCity,
                    merchantID: $merchantId,
                    acquiringBank: $acquiringBank,
                    accountInformation: $accountInformation,
                    currency: $currency,
                    amount: (float) $validated['amount']
                );
                $response = BakongKHQR::generateMerchant($info);
            } else {
                $info = new IndividualInfo(
                    bakongAccountID: $accountId,
                    merchantName: $merchantName,
                    merchantCity: $merchantCity,
                    currency: $currency,
                    amount: (float) $validated['amount']
                );
                $response = BakongKHQR::generateIndividual($info);
            }
            $data = $this->khqrData($response);
        } catch (\Throwable $error) {
            return response()->json(['message' => $error->getMessage()], 422);
        }

        if (! isset($data['qr'], $data['md5'])) {
            return response()->json(['message' => 'Unable to generate KHQR.'], 500);
        }

        $isValid = BakongKHQR::verify($data['qr']);
        if (! $isValid->isValid) {
            return response()->json(['message' => 'Generated KHQR is invalid. Please check your Bakong details.'], 422);
        }

        $transaction = KhqrTransaction::create([
            'user_id' => $request->user()->id,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'currency' => $currencySetting,
            'bakong_account_id' => $accountId,
            'md5' => $data['md5'],
            'qr_string' => $data['qr'],
            'status' => 'pending',
        ]);

        return response()->json([
            'transaction' => [
                'id' => $transaction->id,
                'type' => $transaction->type,
                'amount' => (float) $transaction->amount,
                'currency' => $transaction->currency,
                'status' => $transaction->status,
                'created_at' => $transaction->created_at->toIso8601String(),
            ],
            'qr' => $data['qr'],
            'md5' => $data['md5'],
        ]);
    }

    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'transaction_id' => ['required', 'integer'],
        ]);

        $transaction = KhqrTransaction::query()
            ->where('id', $validated['transaction_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($transaction->status === 'completed') {
            return response()->json(['status' => $transaction->status]);
        }

        $token = config('services.bakong.api_token');
        if (! $token) {
            return response()->json(['message' => 'Bakong API token is missing.'], 500);
        }

        $isTest = filter_var(config('services.bakong.is_test'), FILTER_VALIDATE_BOOL);
        try {
            $bakong = new BakongKHQR($token);
            $response = $bakong->checkTransactionByMD5($transaction->md5 ?? '', $isTest);
        } catch (\Throwable $error) {
            return response()->json(['message' => $error->getMessage()], 422);
        }

        $newStatus = $this->statusFromResponse($response);
        if ($newStatus !== $transaction->status) {
            $transaction->status = $newStatus;
            $transaction->save();
        }

        return response()->json([
            'status' => $transaction->status,
            'raw' => $response,
        ]);
    }

    private function khqrData(KHQRResponse $response): array
    {
        if ($response->status['code'] !== 0) {
            return [];
        }

        return is_array($response->data) ? $response->data : [];
    }

    private function statusFromResponse(array $response): string
    {
        $status = data_get($response, 'data.transactionStatus')
            ?? data_get($response, 'data.status')
            ?? data_get($response, 'transactionStatus')
            ?? data_get($response, 'status');

        if (is_string($status)) {
            $statusValue = strtolower($status);
            if (in_array($statusValue, ['success', 'successful', 'completed', 'paid'], true)) {
                return 'completed';
            }
            if (in_array($statusValue, ['failed', 'rejected', 'cancelled', 'canceled'], true)) {
                return 'failed';
            }
            if (in_array($statusValue, ['pending', 'processing'], true)) {
                return 'pending';
            }
        }

        $responseCode = data_get($response, 'responseCode');
        if ($responseCode === 0 || $responseCode === '0') {
            $data = data_get($response, 'data');
            if (! empty($data)) {
                return 'completed';
            }
        }

        return 'pending';
    }
}
