<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('Auth.login', [
            'brand' => $this->brand(),
        ]);
    }

    public function showRegister(): View
    {
        return view('Auth.register', [
            'brand' => $this->brand(),
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = $validated['login'];
        $loginField = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $remember = $request->boolean('remember');

        if (Auth::attempt([$loginField => $loginValue, 'password' => $validated['password']], $remember)) {
            $request->session()->regenerate();

            $user = $request->user();

            if ($user && !$user->email_verified_at) {
                if ($this->needsVerificationCode($user)) {
                    $this->sendVerificationCode($user);
                }

                return redirect()
                    ->route('verification.notice')
                    ->with('status', 'We sent a 6-digit verification code to your email.');
            }

            return redirect()->route('home');
        }

        return back()
            ->withErrors(['login' => 'These credentials do not match our records.'])
            ->withInput();
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $this->sendVerificationCode($user);

        return redirect()
            ->route('verification.notice')
            ->with('status', 'We sent a 6-digit verification code to your email.');
    }

    public function showVerify(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user && $user->email_verified_at) {
            return redirect()->route('home');
        }

        if ($user && $this->needsVerificationCode($user)) {
            $this->sendVerificationCode($user);
        }

        return view('Auth.verify-email', [
            'brand' => $this->brand(),
            'user' => $user,
        ]);
    }

    public function verifyEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        if (!$user->email_verification_code || !$user->email_verification_expires_at) {
            return back()->withErrors(['code' => 'Please request a new verification code.']);
        }

        if ($user->email_verification_expires_at->isPast()) {
            return back()->withErrors(['code' => 'The verification code has expired.']);
        }

        if (!Hash::check($validated['code'], $user->email_verification_code)) {
            return back()->withErrors(['code' => 'The verification code is invalid.']);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'email_verification_expires_at' => null,
        ])->save();

        return redirect()
            ->route('home')
            ->with('status', 'Email verified successfully.');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        $this->sendVerificationCode($user);

        return back()->with('status', 'We sent a new verification code to your email.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function needsVerificationCode(User $user): bool
    {
        if (!$user->email_verification_code || !$user->email_verification_expires_at) {
            return true;
        }

        return $user->email_verification_expires_at->isPast();
    }

    private function sendVerificationCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'email_verification_code' => Hash::make($code),
            'email_verification_expires_at' => now()->addMinutes(15),
        ])->save();

        Mail::to($user->email)->send(new EmailVerificationCode($user, $code, $this->brand()));
    }
}
