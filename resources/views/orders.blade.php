@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandFull = trim($brandName . $brandAccent);
    $brandIcon = $brand['logo_icon'] ?? 'sports_esports';
    $user = auth()->user();
    $userInitial = $user ? strtoupper(substr($user->name, 0, 1)) : 'U';
    $avatarUrl = $user && $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
@endphp
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $brandFull }} | Orders</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b4bee",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101322",
                    },
                    fontFamily: {
                        "display": ["Spline Sans"]
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Spline Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
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

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display min-h-screen pb-24">
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 pt-4 pb-3">
        @include('components.topbar', ['showProfile' => true])
        <div class="flex gap-3 overflow-x-auto hide-scrollbar pb-2">
            <button class="px-4 py-2 rounded-full bg-primary text-white text-xs font-semibold" type="button">
                Active
            </button>
            <button
                class="px-4 py-2 rounded-full bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 text-xs font-semibold"
                type="button">
                Completed
            </button>
            <button
                class="px-4 py-2 rounded-full bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 text-xs font-semibold"
                type="button">
                Canceled
            </button>
        </div>
    </header>
    <main class="px-4 mt-4 space-y-6">
        <section class="grid grid-cols-3 gap-3">
            <div class="bg-white dark:bg-slate-900 rounded-xl p-3 border border-slate-200 dark:border-slate-800/60">
                <p class="text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Pending</p>
                <p class="text-lg font-bold mt-1">{{ $counts['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-3 border border-slate-200 dark:border-slate-800/60">
                <p class="text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Completed</p>
                <p class="text-lg font-bold mt-1">{{ $counts['completed'] ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-3 border border-slate-200 dark:border-slate-800/60">
                <p class="text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Disputes</p>
                <p class="text-lg font-bold mt-1">{{ $counts['disputed'] ?? 0 }}</p>
            </div>
        </section>
        <section class="space-y-3">
            @forelse ($orders as $order)
                @php
                    $status = $order->status ?? 'pending';
                    $statusLabel = strtoupper($status);
                    $statusClass = match ($status) {
                        'completed' => 'text-emerald-500',
                        'pending' => 'text-yellow-500',
                        'disputed' => 'text-red-500',
                        'canceled' => 'text-slate-500',
                        default => 'text-slate-500',
                    };
                    $title = $order->listing?->title ?? 'Custom Order';
                    $orderNumber = $order->order_number ?: $order->id;
                @endphp
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200 dark:border-slate-800/60 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold">{{ $title }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Order #{{ $orderNumber }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold {{ $status === 'completed' ? 'text-emerald-500' : 'text-yellow-500' }}">
                            {{ number_format($order->total_amount, 2) }} {{ strtoupper($order->currency) }}
                        </p>
                        <p class="text-[10px] uppercase tracking-widest {{ $statusClass }}">{{ $statusLabel }}</p>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white/70 dark:bg-slate-900/70 border border-dashed border-slate-300 dark:border-slate-800 rounded-xl p-6 text-center text-sm text-slate-500">
                    No orders yet. Orders will show here after purchase.
                </div>
            @endforelse
        </section>
    </main>
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
        <a class="flex flex-col items-center gap-1 text-primary" href="{{ route('orders') }}">
            <span class="material-icons text-2xl">receipt_long</span>
            <span class="text-[10px] font-bold">Orders</span>
        </a>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('profile') }}">
            <span class="material-icons text-2xl">person</span>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </nav>
</body>

</html>
