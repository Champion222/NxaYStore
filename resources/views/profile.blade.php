@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandFull = trim($brandName . $brandAccent);
    $brandIcon = $brand['logo_icon'] ?? 'sports_esports';
    $user = $user ?? auth()->user();
    $userInitial = $user ? strtoupper(substr($user->name, 0, 1)) : 'U';
    $avatarUrl = $user && $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
@endphp
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $brandFull }} | Profile</title>
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
        .neon-border {
            box-shadow: 0 0 15px rgba(157, 78, 221, 0.4);
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
        .glass-card {
            background: rgba(15, 17, 26, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-dark text-slate-100 font-display min-h-screen pb-24">
    <header class="relative">
        <div class="h-56 w-full relative overflow-hidden">
            <img class="w-full h-full object-cover opacity-70" data-alt="Futuristic gaming setup cover photo"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwRcvUTFkmyPP7_w_dBx-dDHTFG_R9OhIevLdXIwQUbLn3loaiOP9Be1pkJBJ7I4UfChsVf9sMxJb8lR-DJwoovfQKSQYjzpXGyECB3Pow_d6SdDEKRcK5SOGhtFRam5OG6te9zGYlJq97jPuuyfxhxxHOubGQ1tCRUDXwAEju-jb_TyD7wVDCK8bAok80UL9orMb4970i6pKOGPsHg25dNuduJJIiA1tdWe97NjaVFbcDr5fyq79Yeg2eWGl11RHpa4NmyhQ4y3f6" />
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/30 to-transparent">
            </div>
            <div class="absolute top-12 left-4 right-4 flex justify-between items-center">
                <a class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white border border-white/10"
                    href="{{ route('home') }}">
                    <span class="material-symbols-outlined">arrow_back_ios_new</span>
                </a>
                <div class="flex gap-2">
                    <button
                        class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white border border-white/10"
                        type="button">
                        <span class="material-symbols-outlined">share</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white border border-white/10"
                            type="submit">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="px-4 -mt-16 relative z-10">
            <div class="flex items-end justify-between mb-4">
                <div class="relative">
                    <div
                        class="w-28 h-28 rounded-3xl overflow-hidden border-[5px] border-background-dark shadow-2xl neon-border relative bg-card-dark flex items-center justify-center">
                        <img class="w-full h-full object-cover {{ $avatarUrl ? '' : 'hidden' }}" id="avatar-preview"
                            alt="{{ $user?->name }} avatar" src="{{ $avatarUrl ?? '' }}" />
                        <span class="text-3xl font-bold text-accent {{ $avatarUrl ? 'hidden' : '' }}"
                            id="avatar-initial">{{ $userInitial }}</span>
                    </div>
                    <label
                        class="absolute bottom-1 right-1 w-9 h-9 bg-accent rounded-full border-4 border-background-dark flex items-center justify-center shadow-lg cursor-pointer">
                        <span class="material-symbols-outlined text-white text-[18px] fill-1">edit</span>
                        <input class="hidden" form="profile-form" id="avatar-input" name="avatar" accept="image/*"
                            type="file" />
                    </label>
                </div>
                <div class="pb-1">
                    <button
                        class="px-5 py-3 bg-gradient-to-r from-accent to-primary text-white rounded-2xl text-sm font-bold shadow-lg shadow-accent/25 flex items-center gap-2 active:scale-95 transition-transform"
                        form="profile-form" type="submit">
                        <span class="material-symbols-outlined text-[18px] fill-1">save</span> Save Profile
                    </button>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">{{ $user?->name }}</h1>
                    <p class="text-slate-400 text-sm font-medium">{{ $brandFull }} Member</p>
                </div>
                <form action="{{ route('profile.update') }}" class="grid grid-cols-1 gap-3" enctype="multipart/form-data"
                    id="profile-form" method="POST">
                    @csrf
                    <div class="glass-card rounded-2xl p-3">
                        <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Display Name</label>
                        <input
                            class="mt-2 w-full bg-transparent border border-white/10 rounded-xl px-3 py-2 text-sm text-white placeholder:text-slate-500 focus:border-accent focus:ring-accent"
                            name="name" type="text" value="{{ old('name', $user?->name) }}" />
                    </div>
                    @if (session('status'))
                        <div class="glass-card rounded-2xl p-3 text-xs text-emerald-300">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="glass-card rounded-2xl p-3 text-xs text-red-300">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
            <div class="mt-4">
                <a class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-accent to-primary text-white rounded-2xl text-sm font-bold shadow-lg shadow-accent/25 active:scale-95 transition-transform"
                    href="{{ route('billing') }}">
                    <span class="material-symbols-outlined text-[18px] fill-1">payments</span>
                    Payment & Billing
                </a>
            </div>
            <div class="grid grid-cols-3 gap-3 mt-6">
                <div class="bg-card-dark p-3 rounded-2xl border border-white/5 flex flex-col items-center">
                    <p class="text-slate-500 text-[9px] font-bold uppercase mb-1 tracking-widest">Trust Score</p>
                    <p class="text-lg font-bold text-emerald-400">{{ $stats['trust_score'] ?? 100 }}%</p>
                </div>
                <div class="bg-card-dark p-3 rounded-2xl border border-white/5 flex flex-col items-center">
                    <p class="text-slate-500 text-[9px] font-bold uppercase mb-1 tracking-widest">Total Sales</p>
                    <p class="text-lg font-bold">{{ $stats['total_sales'] ?? 0 }}</p>
                </div>
                <div class="bg-card-dark p-3 rounded-2xl border border-white/5 flex flex-col items-center">
                    <p class="text-slate-500 text-[9px] font-bold uppercase mb-1 tracking-widest">Joined</p>
                    <p class="text-lg font-bold">{{ $stats['joined'] ?? now()->format('Y') }}</p>
                </div>
            </div>
        </div>
    </header>
    <nav class="mt-8 px-4 border-b border-white/5 sticky top-0 bg-background-dark/95 backdrop-blur-xl z-20">
        <div class="flex gap-6 overflow-x-auto hide-scrollbar">
            <button class="pb-4 text-sm font-bold border-b-2 border-accent text-accent whitespace-nowrap"
                type="button">Account Listings</button>
            <button class="pb-4 text-sm font-medium text-slate-500 whitespace-nowrap" type="button">Service Offerings</button>
            <button class="pb-4 text-sm font-medium text-slate-500 whitespace-nowrap" type="button">Reviews (84)</button>
        </div>
    </nav>
    <main class="px-4 mt-6">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold">Featured Storefront</h2>
                <span class="px-2 py-0.5 bg-white/5 text-slate-400 text-[10px] font-bold rounded-lg uppercase">
                    {{ $stats['active_listings'] ?? 0 }} ACTIVE
                </span>
            </div>
            <button class="w-10 h-10 rounded-xl bg-card-dark border border-white/5 flex items-center justify-center text-slate-400"
                type="button">
                <span class="material-symbols-outlined text-[20px]">tune</span>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @forelse ($listings ?? [] as $listing)
                <div class="bg-card-dark border border-white/5 rounded-2xl overflow-hidden shadow-lg">
                    <div class="aspect-[4/5] relative">
                        @if ($listing->image_url)
                            <img class="w-full h-full object-cover" alt="{{ $listing->title }}"
                                src="{{ $listing->image_url }}" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-slate-900/40"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-card-dark via-transparent to-transparent"></div>
                        <div
                            class="absolute top-2 left-2 px-2 py-1 bg-black/60 backdrop-blur-md rounded-lg text-[9px] font-bold uppercase text-accent border border-accent/30">
                            {{ strtoupper($listing->category ?? 'Listing') }}
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-white font-bold text-lg mb-0.5">
                            {{ number_format($listing->price, 2) }} {{ strtoupper($listing->currency) }}
                        </p>
                        <h3 class="font-bold text-[11px] text-slate-300 leading-tight line-clamp-2 h-7 mb-2">
                            {{ \Illuminate\Support\Str::limit($listing->title, 48) }}
                        </h3>
                        @if ($listing->description)
                            <div class="flex gap-1.5 flex-wrap">
                                <span class="text-[9px] px-1.5 py-0.5 bg-white/5 text-slate-400 rounded">
                                    {{ \Illuminate\Support\Str::limit($listing->description, 24) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 glass-card rounded-2xl p-4 text-sm text-slate-400">
                    No listings yet. Add listings to show them here.
                </div>
            @endforelse
        </div>

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
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarInitial = document.getElementById('avatar-initial');

        if (avatarInput && avatarPreview && avatarInitial) {
            avatarInput.addEventListener('change', (event) => {
                const file = event.target.files && event.target.files[0];
                if (!file || !file.type.startsWith('image/')) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = () => {
                    avatarPreview.src = reader.result;
                    avatarPreview.classList.remove('hidden');
                    avatarInitial.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</body>

</html>
