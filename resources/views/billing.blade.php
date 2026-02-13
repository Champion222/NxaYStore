@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandFull = trim($brandName . $brandAccent);
    $brandIcon = $brand['logo_icon'] ?? 'sports_esports';
    $user = auth()->user();
    $userInitial = $user ? strtoupper(substr($user->name, 0, 1)) : 'U';
    $avatarUrl = $user && $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
    $defaultCurrency = strtoupper(config('services.bakong.currency', 'USD'));
    $amountStep = $defaultCurrency === 'KHR' ? '1' : '0.01';
    $amountMin = $defaultCurrency === 'KHR' ? '1' : '0.01';
@endphp
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $brandFull }} | Payment &amp; Billing</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b4bee",
                        "accent": "#9d4edd",
                        "background-light": "#f6f6f8",
                        "background-dark": "#05070a",
                        "card-dark": "#0f111a",
                    },
                    fontFamily: {
                        "display": ["Spline Sans"]
                    },
                    borderRadius: { "DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Spline Sans', sans-serif;
                -webkit-tap-highlight-color: transparent;
            }
        }
        .glass-card {
            background: rgba(15, 17, 26, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .neon-glow {
            box-shadow: 0 0 15px rgba(43, 75, 238, 0.3);
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-dark text-slate-100 font-display min-h-screen pb-24">
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 pt-4 pb-3">
        @include('components.topbar')
    </header>
    <main class="px-4 py-6 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-bold">Payment &amp; Billing</h1>
        </div>
        <section>
            <div
                class="bg-gradient-to-br from-card-dark to-black border border-white/5 rounded-[2rem] p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Available Funds</p>
                    <div class="flex items-end gap-2 mb-6">
                        <span class="text-4xl font-bold tracking-tight text-white" id="balance-amount"
                            data-balance="{{ $balance }}" data-currency="{{ $balanceCurrency }}">
                            {{ number_format($balance, 2) }} {{ strtoupper($balanceCurrency) }}
                        </span>
                        <span class="text-emerald-400 text-sm font-bold mb-1.5 flex items-center">
                            <span class="material-symbols-outlined text-sm">arrow_upward</span> 12%
                        </span>
                    </div>
                    <div class="flex gap-3">
                        <button
                            class="flex-1 bg-white text-black py-3.5 rounded-2xl font-bold text-sm shadow-xl active:scale-95 transition-transform flex items-center justify-center gap-2"
                            id="withdraw-open" type="button">
                            <span
                                class="material-symbols-outlined text-[20px] fill-1">account_balance_wallet</span>
                            Withdraw
                        </button>
                        <button
                            class="w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-white active:scale-95 transition-transform"
                            id="topup-open" type="button">
                            <span class="material-symbols-outlined">add</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="glass-card rounded-2xl p-4 space-y-2">
            <div class="flex items-center justify-between">
                <h2 class="text-md font-bold text-slate-200">Bakong KHQR</h2>
                <span class="text-xs text-slate-500">No cards</span>
            </div>
            <p class="text-xs text-slate-400">Top up or withdraw using KHQR.</p>
            <div class="text-xs text-slate-400">
                <span class="font-semibold text-slate-300">Merchant ID:</span>
                {{ config('services.bakong.account_id') }}
            </div>
        </section>
        <section class="space-y-4 pb-12">
            <div class="flex items-center justify-between px-1">
                <h2 class="text-md font-bold text-slate-200">Transaction History</h2>
                <button class="text-slate-400 text-xs font-bold uppercase tracking-wider flex items-center gap-1"
                    type="button">
                    Filter <span class="material-symbols-outlined text-sm">filter_list</span>
                </button>
            </div>
            <div class="space-y-3" id="transaction-list">
                @forelse ($transactions as $transaction)
                    @php
                        $isTopup = $transaction->type === 'topup';
                        $status = $transaction->status;
                        $statusLabel = strtoupper($status);
                        $statusClass = match ($status) {
                            'completed' => 'text-emerald-400',
                            'failed' => 'text-red-400',
                            default => 'text-yellow-500',
                        };
                        $icon = $isTopup ? 'trending_up' : 'account_balance_wallet';
                        $iconBg = $isTopup ? 'bg-emerald-500/10 text-emerald-400' : 'bg-primary/10 text-primary';
                        $amountPrefix = $isTopup ? '+' : '-';
                        $amountClass = $isTopup ? 'text-emerald-400' : 'text-white';
                    @endphp
                    <div class="bg-card-dark/50 border border-white/5 rounded-2xl p-4 flex items-center gap-4"
                        data-transaction-id="{{ $transaction->id }}" data-status="{{ $status }}"
                        data-type="{{ $transaction->type }}" data-amount="{{ $transaction->amount }}"
                        data-currency="{{ strtoupper($transaction->currency) }}">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $iconBg }}">
                            <span class="material-symbols-outlined">{{ $icon }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold">
                                {{ $isTopup ? 'KHQR Top Up' : 'KHQR Withdraw' }}
                            </h3>
                            <p class="text-xs text-slate-500">{{ $transaction->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold {{ $amountClass }}">
                                {{ $amountPrefix }}{{ number_format($transaction->amount, 2) }} {{ strtoupper($transaction->currency) }}
                            </p>
                            <p class="transaction-status text-[10px] font-medium uppercase tracking-wider {{ $statusClass }}"
                                data-status-label="true">
                                {{ $statusLabel }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="glass-card rounded-2xl p-4 text-sm text-slate-400">
                        No transactions yet.
                    </div>
                @endforelse
            </div>
            <button
                class="w-full py-4 text-slate-500 text-sm font-bold uppercase tracking-widest border border-dashed border-white/10 rounded-2xl"
                type="button">
                View All History
            </button>
        </section>
    </main>

    <div class="fixed inset-0 hidden items-center justify-center z-50" id="khqr-modal">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative w-full max-w-sm mx-4 glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold" id="khqr-title">Top Up with KHQR</h2>
                <button class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center" id="khqr-close"
                    type="button">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <input
                        class="w-full bg-transparent border border-white/10 rounded-xl px-3 py-2 text-sm text-white placeholder:text-slate-500 focus:border-accent focus:ring-accent"
                        id="khqr-amount" min="{{ $amountMin }}" placeholder="Amount" step="{{ $amountStep }}"
                        type="number" />
                    <select
                        class="w-full bg-transparent border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:border-accent focus:ring-accent"
                        id="khqr-currency" {{ $defaultCurrency === 'KHR' ? 'disabled' : '' }}>
                        @if ($defaultCurrency === 'KHR')
                            <option value="KHR" selected>KHR</option>
                        @else
                            <option value="USD" {{ $defaultCurrency === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="KHR">KHR</option>
                        @endif
                    </select>
                </div>
                <div class="hidden" id="khqr-account-row">
                    <input
                        class="w-full bg-transparent border border-white/10 rounded-xl px-3 py-2 text-sm text-white placeholder:text-slate-500 focus:border-accent focus:ring-accent"
                        id="khqr-account" placeholder="Your Bakong ID" type="text" />
                </div>
                <button
                    class="w-full rounded-xl bg-gradient-to-r from-accent to-primary py-2.5 text-xs font-bold uppercase tracking-widest text-white"
                    id="khqr-generate" type="button">
                    Generate KHQR
                </button>
                <p class="text-xs text-red-300 hidden" id="khqr-error"></p>
            </div>
            <div class="hidden mt-4 space-y-3" id="khqr-qr-section">
                <div class="bg-white rounded-xl p-3 flex justify-center">
                    <img alt="KHQR Code" class="w-[220px] h-[220px]" id="khqr-image" />
                </div>
                <p class="text-xs text-slate-300" id="khqr-status"></p>
            </div>
        </div>
    </div>

    <nav
        class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-background-dark/95 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800/50 px-6 py-3 flex items-center justify-between z-50">
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('home') }}">
            <span class="material-icons text-2xl">home</span>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('market') }}">
            <span class="material-icons text-2xl">shopping_bag</span>
            <span class="text-[10px] font-medium">Market</span>
        </a>
        <div class="relative -mt-10">
            <button
                class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center shadow-lg shadow-primary/40 border-4 border-background-light dark:border-background-dark"
                type="button">
                <span class="material-icons text-3xl">add</span>
            </button>
        </div>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('orders') }}">
            <span class="material-icons text-2xl">receipt_long</span>
            <span class="text-[10px] font-medium">Orders</span>
        </a>
        <a class="flex flex-col items-center gap-1 text-primary" href="{{ route('profile') }}">
            <span class="material-icons text-2xl">person</span>
            <span class="text-[10px] font-bold">Profile</span>
        </a>
    </nav>

    <script>
        const modal = document.getElementById('khqr-modal');
        const closeModalBtn = document.getElementById('khqr-close');
        const openTopupBtn = document.getElementById('topup-open');
        const openWithdrawBtn = document.getElementById('withdraw-open');
        const amountInput = document.getElementById('khqr-amount');
        const currencySelect = document.getElementById('khqr-currency');
        const accountRow = document.getElementById('khqr-account-row');
        const accountInput = document.getElementById('khqr-account');
        const generateBtn = document.getElementById('khqr-generate');
        const titleEl = document.getElementById('khqr-title');
        const qrSection = document.getElementById('khqr-qr-section');
        const qrImage = document.getElementById('khqr-image');
        const errorEl = document.getElementById('khqr-error');
        const statusEl = document.getElementById('khqr-status');
        const transactionList = document.getElementById('transaction-list');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const defaultCurrency = "{{ $defaultCurrency }}";
        const generateUrl = "{{ route('billing.khqr.generate') }}";
        const verifyUrl = "{{ route('billing.khqr.verify') }}";
        const balanceEl = document.getElementById('balance-amount');
        let currentBalance = balanceEl ? parseFloat(balanceEl.dataset.balance || '0') : 0;
        const balanceCurrency = balanceEl?.dataset.currency || defaultCurrency;

        let currentType = 'topup';
        let currentTransactionId = null;
        let pollingTimer = null;

        function startPolling() {
            stopPolling();
            pollingTimer = setInterval(async () => {
                if (!currentTransactionId) return;
                try {
                    const response = await fetch(verifyUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ transaction_id: currentTransactionId }),
                    });
                    const data = await response.json();
                    if (!response.ok) {
                        return;
                    }
                    updateTransactionStatus(currentTransactionId, data.status);
                    if (data.status === 'completed') {
                        statusEl.textContent = 'Payment completed successfully.';
                        statusEl.classList.remove('text-red-300', 'text-yellow-300');
                        statusEl.classList.add('text-emerald-300');
                        stopPolling();
                    } else if (data.status === 'failed') {
                        statusEl.textContent = 'Payment failed.';
                        statusEl.classList.remove('text-emerald-300', 'text-yellow-300');
                        statusEl.classList.add('text-red-300');
                        stopPolling();
                    } else {
                        statusEl.textContent = 'Waiting for payment...';
                        statusEl.classList.remove('text-emerald-300', 'text-red-300');
                        statusEl.classList.add('text-yellow-300');
                    }
                } catch (error) {
                    // ignore polling errors
                }
            }, 4000);
        }

        function stopPolling() {
            if (pollingTimer) {
                clearInterval(pollingTimer);
                pollingTimer = null;
            }
        }

        function openModal(type) {
            currentType = type;
            titleEl.textContent = type === 'withdraw' ? 'Withdraw with KHQR' : 'Top Up with KHQR';
            accountRow.classList.toggle('hidden', type !== 'withdraw');
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
            statusEl.textContent = '';
            qrSection.classList.add('hidden');
            currentTransactionId = null;
            amountInput.value = '';
            currencySelect.value = defaultCurrency;
            accountInput.value = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            stopPolling();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function statusClass(status) {
            if (status === 'completed') return 'text-emerald-400';
            if (status === 'failed') return 'text-red-400';
            return 'text-yellow-500';
        }

        function renderTransaction(tx) {
            const isTopup = tx.type === 'topup';
            const icon = isTopup ? 'trending_up' : 'account_balance_wallet';
            const iconBg = isTopup ? 'bg-emerald-500/10 text-emerald-400' : 'bg-primary/10 text-primary';
            const amountPrefix = isTopup ? '+' : '-';
            const amountClass = isTopup ? 'text-emerald-400' : 'text-white';
            const dateText = new Date(tx.created_at).toLocaleString();
            const statusLabel = String(tx.status).toUpperCase();
            return `
                <div class="bg-card-dark/50 border border-white/5 rounded-2xl p-4 flex items-center gap-4" data-transaction-id="${tx.id}" data-status="${tx.status}" data-type="${tx.type}" data-amount="${tx.amount}" data-currency="${tx.currency}">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center ${iconBg}">
                        <span class="material-symbols-outlined">${icon}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold">${isTopup ? 'KHQR Top Up' : 'KHQR Withdraw'}</h3>
                        <p class="text-xs text-slate-500">${dateText}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold ${amountClass}">${amountPrefix}${Number(tx.amount).toFixed(2)} ${tx.currency}</p>
                        <p class="transaction-status text-[10px] font-medium uppercase tracking-wider ${statusClass(tx.status)}" data-status-label="true">${statusLabel}</p>
                    </div>
                </div>
            `;
        }

        function updateTransactionStatus(id, status) {
            const item = document.querySelector(`[data-transaction-id="${id}"]`);
            if (!item) return;
            const previousStatus = item.dataset.status;
            item.dataset.status = status;
            const statusLabel = item.querySelector('[data-status-label="true"]');
            if (statusLabel) {
                statusLabel.textContent = String(status).toUpperCase();
                statusLabel.classList.remove('text-emerald-400', 'text-red-400', 'text-yellow-500');
                statusLabel.classList.add(statusClass(status));
            }

            if (balanceEl && previousStatus !== 'completed' && status === 'completed') {
                const type = item.dataset.type;
                const amount = parseFloat(item.dataset.amount || '0');
                const currency = item.dataset.currency || defaultCurrency;
                if (currency === balanceCurrency) {
                    currentBalance = currentBalance + (type === 'topup' ? amount : -amount);
                    balanceEl.dataset.balance = currentBalance.toString();
                    balanceEl.textContent = `${currentBalance.toFixed(2)} ${currency}`;
                }
            }
        }

        openTopupBtn?.addEventListener('click', () => openModal('topup'));
        openWithdrawBtn?.addEventListener('click', () => openModal('withdraw'));
        closeModalBtn?.addEventListener('click', closeModal);
        modal?.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        generateBtn?.addEventListener('click', async () => {
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
            statusEl.textContent = '';

            const amount = parseFloat(amountInput.value);
            if (!amount || amount <= 0) {
                errorEl.textContent = 'Please enter a valid amount.';
                errorEl.classList.remove('hidden');
                return;
            }

            const payload = {
                amount,
                currency: currencySelect.value,
                type: currentType,
            };

            if (currentType === 'withdraw') {
                const accountId = accountInput.value.trim();
                if (!accountId) {
                    errorEl.textContent = 'Please enter your Bakong ID for withdrawal.';
                    errorEl.classList.remove('hidden');
                    return;
                }
                payload.bakong_account_id = accountId;
            }

            generateBtn.disabled = true;
            generateBtn.textContent = 'Generating...';

            try {
                const response = await fetch(generateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to generate KHQR.');
                }

                currentTransactionId = data.transaction.id;
                qrSection.classList.remove('hidden');
                qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${encodeURIComponent(data.qr)}`;
                statusEl.textContent = 'Waiting for payment...';
                statusEl.classList.remove('text-emerald-300', 'text-red-300');
                statusEl.classList.add('text-yellow-300');

                if (transactionList) {
                    transactionList.insertAdjacentHTML('afterbegin', renderTransaction(data.transaction));
                }

                startPolling();
            } catch (error) {
                errorEl.textContent = error.message || 'Failed to generate KHQR.';
                errorEl.classList.remove('hidden');
            } finally {
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generate KHQR';
            }
        });
    </script>
</body>

</html>
