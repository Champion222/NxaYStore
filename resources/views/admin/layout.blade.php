@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandFull = trim($brandName . $brandAccent);
@endphp
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $brandFull }} | Admin</title>
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
                        "display": ["Spline Sans", "sans-serif"]
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
            min-height: 100vh;
        }

        .neon-glow {
            box-shadow: 0 0 15px rgba(43, 75, 238, 0.3);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    <div class="min-h-screen">
        <header class="sticky top-0 z-40 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white neon-glow">
                        <span class="material-icons text-2xl">admin_panel_settings</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">Admin</p>
                        <h1 class="text-xl font-bold tracking-tight">{{ $brandName }}{{ $brandAccent }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a class="px-3 py-2 rounded-full text-sm font-semibold text-slate-500 hover:text-white hover:bg-primary/20"
                        href="{{ route('home') }}">Back to App</a>
                </div>
            </div>
            <nav class="max-w-6xl mx-auto px-6 pb-3">
                <div class="flex flex-wrap gap-2">
                    <a class="px-4 py-2 rounded-full text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'bg-white/10 text-slate-500 hover:text-white' }}"
                        href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="px-4 py-2 rounded-full text-sm font-semibold {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'bg-white/10 text-slate-500 hover:text-white' }}"
                        href="{{ route('admin.users.index') }}">Users</a>
                    <a class="px-4 py-2 rounded-full text-sm font-semibold {{ request()->routeIs('admin.listings.*') ? 'bg-primary text-white' : 'bg-white/10 text-slate-500 hover:text-white' }}"
                        href="{{ route('admin.listings.index') }}">Listings</a>
                    <a class="px-4 py-2 rounded-full text-sm font-semibold {{ request()->routeIs('admin.orders.*') ? 'bg-primary text-white' : 'bg-white/10 text-slate-500 hover:text-white' }}"
                        href="{{ route('admin.orders.index') }}">Orders</a>
                </div>
            </nav>
        </header>

        <main class="max-w-6xl mx-auto px-6 py-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>
