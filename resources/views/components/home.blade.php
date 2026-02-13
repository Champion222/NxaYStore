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
    <title>{{ $brandFull }} | Gaming Marketplace</title>
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
    <!-- Header & Navigation -->
    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 pt-4 pb-2">
        @include('components.topbar', ['showProfile' => true])
        <!-- Category Chips -->
        <div class="flex overflow-x-auto gap-3 hide-scrollbar pb-2">
            <button
                class="px-5 py-2 bg-primary text-white rounded-full text-sm font-semibold whitespace-nowrap">Accounts</button>
            <button
                class="px-5 py-2 bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 rounded-full text-sm font-medium whitespace-nowrap">Boosting</button>
            <button
                class="px-5 py-2 bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 rounded-full text-sm font-medium whitespace-nowrap">Coaching</button>
            <button
                class="px-5 py-2 bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 rounded-full text-sm font-medium whitespace-nowrap">Skins</button>
            <button
                class="px-5 py-2 bg-slate-200 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 rounded-full text-sm font-medium whitespace-nowrap">Gift
                Cards</button>
        </div>
    </header>
    <main class="px-4 mt-4 space-y-8">
        <!-- Search Section -->
        <section>
            <div class="relative group">
                <span
                    class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                <input
                    class="w-full bg-slate-100 dark:bg-slate-900 border-none rounded-full py-4 pl-12 pr-4 text-sm focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-slate-500"
                    placeholder="Search for accounts or services..." type="text" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 p-2 bg-primary/10 rounded-full text-primary">
                    <span class="material-icons text-lg">tune</span>
                </button>
            </div>
        </section>
        <!-- Popular Games -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold tracking-tight">Popular Games</h2>
                <button class="text-primary text-sm font-semibold">See All</button>
            </div>
            <div class="grid grid-cols-3 gap-3">
                @forelse ($popularListings as $index => $listing)
                    <div
                        class="relative aspect-[3/4] rounded-xl overflow-hidden group {{ $index === 0 ? 'border-2 border-primary' : '' }}">
                        @if ($listing->image_url)
                            <img class="w-full h-full object-cover" alt="{{ $listing->title }}"
                                src="{{ $listing->image_url }}" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary/30 to-slate-900/40"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2 left-2 right-2">
                            <p class="text-[10px] font-bold text-white leading-tight uppercase tracking-wider">
                                {{ strtoupper($listing->category ?? 'Listing') }}
                            </p>
                        </div>
                        @if ($index === 0)
                            <div
                                class="absolute top-1 right-1 bg-primary text-[8px] px-1.5 py-0.5 rounded-full font-bold text-white uppercase">
                                Hot</div>
                        @endif
                    </div>
                @empty
                    <div
                        class="col-span-3 bg-slate-100 dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 rounded-xl p-6 text-center text-sm text-slate-500">
                        No listings yet. Add listings to see popular games.
                    </div>
                @endforelse
            </div>
        </section>
<!-- Featured Account Deals -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold tracking-tight">Featured Account Deals</h2>
                <div class="flex gap-1">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                </div>
            </div>
            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-4 -mx-4 px-4">
                @forelse ($featuredListings as $listing)
                    <div
                        class="min-w-[280px] bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-xl border border-slate-200 dark:border-primary/20">
                        <div class="relative h-40">
                            @if ($listing->image_url)
                                <img class="w-full h-full object-cover" alt="{{ $listing->title }}"
                                    src="{{ $listing->image_url }}" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-slate-900/40"></div>
                            @endif
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span
                                    class="px-2 py-1 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold rounded flex items-center gap-1">
                                    <span class="material-icons text-[12px] text-primary">diamond</span>
                                    {{ strtoupper($listing->category ?? 'Listing') }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 right-3">
                                <div class="bg-primary text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                    {{ number_format($listing->price, 2) }} {{ strtoupper($listing->currency) }}
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-base mb-1">
                                {{ \Illuminate\Support\Str::limit($listing->title, 40) }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1">
                                <span class="material-icons text-sm">schedule</span>
                                {{ \Illuminate\Support\Str::limit($listing->description ?? 'Instant delivery', 32) }}
                            </p>
                            <div class="flex gap-2">
                                <button
                                    class="flex-1 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/20">Buy
                                    Now</button>
                                <button class="p-2.5 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-500"
                                    type="button">
                                    <span class="material-icons text-sm text-primary">favorite_border</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="min-w-[280px] bg-white/80 dark:bg-slate-900/80 rounded-xl border border-dashed border-slate-300 dark:border-slate-800 p-6 text-center text-sm text-slate-500">
                        No listings yet. Add listings to show featured deals.
                    </div>
                @endforelse
            </div>
        </section>
<!-- Professional Services -->
        <section class="pb-8">
            <h2 class="text-lg font-bold tracking-tight mb-4">Professional Services</h2>
            <div class="grid grid-cols-2 gap-4">
                <div
                    class="bg-gradient-to-br from-primary/20 to-purple-500/10 border border-primary/20 p-4 rounded-xl">
                    <div
                        class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center text-primary mb-3">
                        <span class="material-icons">bolt</span>
                    </div>
                    <h3 class="font-bold text-sm mb-1">Rank Boosting</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-tight">Fast delivery by pro
                        players.</p>
                </div>
                <div
                    class="bg-gradient-to-br from-indigo-500/20 to-blue-500/10 border border-indigo-500/20 p-4 rounded-xl">
                    <div
                        class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-500 mb-3">
                        <span class="material-icons">school</span>
                    </div>
                    <h3 class="font-bold text-sm mb-1">Pro Coaching</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-tight">Learn from Top 500
                        veterans.</p>
                </div>
            </div>
        </section>
    </main>
    <!-- Persistent Bottom Nav -->
    <nav
        class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-background-dark/95 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800/50 px-6 py-3 flex items-center justify-between z-50">
        <button class="flex flex-col items-center gap-1 text-primary">
            <span class="material-icons text-2xl">home</span>
            <span class="text-[10px] font-bold">Home</span>
        </button>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('market') }}">
            <span class="material-icons text-2xl">shopping_bag</span>
            <span class="text-[10px] font-medium">Market</span>
        </a>
        <div class="relative -mt-10">
            <button
                class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center shadow-lg shadow-primary/40 border-4 border-background-light dark:border-background-dark">
                <span class="material-icons text-3xl">add</span>
            </button>
        </div>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('orders') }}">
            <span class="material-icons text-2xl">receipt_long</span>
            <span class="text-[10px] font-medium">Orders</span>
        </a>
        <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('profile') }}">
            <span class="material-icons text-2xl">person</span>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </nav>
</body>

</html>
