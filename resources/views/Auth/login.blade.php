@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandFull = trim($brandName . $brandAccent);
    $brandTagline = $brand['tagline'] ?? 'Level Up Your Inventory';
    $brandIcon = $brand['logo_icon'] ?? 'sports_esports';
    $brandFullUpper = strtoupper($brandName . $brandAccent);
@endphp
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $brandFull }} - Login</title>
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
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Mobile Screen Container (iOS Phone Frame Emulation) -->
    <div class="relative w-full h-screen max-w-md bg-background-dark overflow-hidden flex flex-col">
        <!-- Hero Section: Cinematic Gaming Background -->
        <div class="relative h-[40%] w-full">
            <div
                class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/40 to-transparent z-10">
            </div>
            <div class="absolute inset-0 bg-primary/20 mix-blend-multiply z-10"></div>
            <img alt="Cinematic gaming illustration" class="absolute inset-0 w-full h-full object-cover"
                data-alt="Cinematic high-quality esports gaming illustration"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTVYRYjgWmNbOw4DHa5BXZguQFnIuFKIioMPExdp-i3_JQwmHI23cN5yz4TdBGAPeAYpAn1GCP1h8qPxwm15sufMhXkwvZ5XoOMm2zrJVLSgOUe9PXr5BLjkse7_52AqxCngJhWnDqIjVxWJuWGbhoF2Yr3_Re3bA95uSLLgf1ZDWgMidf9pC6yIY4zIzIF4GsToF4ZJSGuvefC8xCxrqZesxq1KDbl2mLanUxNHAgvRGdRs4Phyebr3nPEXoZpQmWe9cmcwkH26qU" />
            <!-- Logo & Title -->
            <div class="relative z-20 flex flex-col items-center justify-center h-full pt-12">
                <div
                    class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/40 mb-4">
                    <span class="material-icons text-white text-4xl">{{ $brandIcon }}</span>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    {{ $brandName }}<span class="text-primary">{{ $brandAccent }}</span>
                </h1>
                <p class="text-slate-300 text-sm font-medium mt-1">{{ $brandTagline }}</p>
            </div>
        </div>
        <!-- Login Form Container -->
        <div class="relative z-30 flex-1 bg-background-dark px-8 pt-8 pb-12 rounded-t-xl -mt-6">
            <div class="w-12 h-1.5 bg-slate-700/50 rounded-full mx-auto mb-8"></div>
            <header class="mb-8">
                <h2 class="text-2xl font-bold">Welcome Back</h2>
                <p class="text-slate-400 text-sm">Sign in to manage your gaming assets</p>
            </header>
            <!-- Form -->
            <form action="{{ route('login.perform') }}" class="space-y-5" id="login-form" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        <p class="font-semibold">Login failed</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Username/Email -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <span
                            class="material-icons text-slate-500 group-focus-within:text-primary transition-colors text-xl">alternate_email</span>
                    </div>
                    <input
                        class="w-full bg-slate-800/50 border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-full py-4 pl-12 pr-4 text-white placeholder:text-slate-500 transition-all duration-300 outline-none"
                        name="login" placeholder="Email or Username" type="text" value="{{ old('login') }}" />
                </div>
                <!-- Password -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <span
                            class="material-icons text-slate-500 group-focus-within:text-primary transition-colors text-xl">lock_open</span>
                    </div>
                    <input
                        class="w-full bg-slate-800/50 border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-full py-4 pl-12 pr-12 text-white placeholder:text-slate-500 transition-all duration-300 outline-none"
                        name="password" placeholder="Password" type="password" />
                    <button
                        class="absolute inset-y-0 right-4 flex items-center text-slate-500 hover:text-white transition-colors"
                        type="button">
                        <span class="material-icons text-xl">visibility</span>
                    </button>
                </div>
                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input
                            class="w-5 h-5 rounded-full border-slate-700 bg-slate-800 text-primary focus:ring-primary focus:ring-offset-background-dark"
                            name="remember" type="checkbox" />
                        <span class="text-sm text-slate-400 group-hover:text-slate-200 transition-colors">Remember
                            me</span>
                    </label>
                    <a class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors"
                        href="#">Forgot Password?</a>
                </div>
                <!-- Login Button -->
                <button
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-full shadow-lg shadow-primary/30 active:scale-95 transition-all duration-200 mt-2 flex items-center justify-center"
                    id="login-submit" type="submit">
                    <span id="login-text">LOGIN TO {{ $brandFullUpper }}</span>
                    <span class="material-icons ml-2 hidden animate-spin" id="login-spinner">progress_activity</span>
                </button>
            </form>
            <!-- Divider -->
            <div class="relative flex items-center my-10">
                <div class="flex-grow border-t border-slate-800"></div>
                <span class="flex-shrink mx-4 text-slate-500 text-xs font-bold tracking-widest uppercase">Or connect
                    via</span>
                <div class="flex-grow border-t border-slate-800"></div>
            </div>
            <!-- Social Logins -->
            <div class="grid grid-cols-3 gap-4">
                <button
                    class="flex items-center justify-center bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 rounded-full py-3 transition-colors">
                    <img alt="Google" class="w-5 h-5" data-alt="Google logo icon"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCD7WZCYTJalGCKDgID8d4O75oTUaONrZLrwJfgRGFx8tSg5iMjLuDS992eQXbwViHB83HZ_RB4j-bekEiJbZDvjpjiZ2P3xMaRtK88zueUwEQz9P4w152ZTbG3fqfHWULOd-KmbxhbNphxFR2jRHe6zNq4TVrJBKkcl2hJIVoUWO9qSIGxJTndG90DtBl0TvXM9ZKLwaRxbReVtQvuXZuz5Qbh0WjA7KhfVyYEX-XiTVkHhxFw-P1gu_b7NudD3DBs5qPW1URCuUsk" />
                </button>
                <button
                    class="flex items-center justify-center bg-slate-800/50 hover:bg-[#5865F2]/20 border border-slate-700/50 rounded-full py-3 group transition-colors">
                    <svg class="w-5 h-5 fill-slate-300 group-hover:fill-[#5865F2]" viewbox="0 0 24 24">
                        <path
                            d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03z">
                        </path>
                    </svg>
                </button>
                <button
                    class="flex items-center justify-center bg-slate-800/50 hover:bg-slate-700 border border-slate-700/50 rounded-full py-3 group transition-colors">
                    <svg class="w-5 h-5 fill-slate-300 group-hover:fill-white" viewbox="0 0 24 24">
                        <path
                            d="M22 14.331c0-1.879-1.523-3.411-3.411-3.411h-.101a1.2 1.2 0 0 1-1.2-1.2V9.6a1.2 1.2 0 0 1 1.2-1.2h.101C20.477 8.4 22 6.878 22 5c0-1.878-1.523-3.4-3.4-3.4H5.4C3.523 1.6 2 3.122 2 5c0 1.878 1.523 3.4 3.4 3.4h.101A1.2 1.2 0 0 1 6.7 9.6v.12a1.2 1.2 0 0 1-1.2 1.2h-.1C3.523 10.92 2 12.452 2 14.331c0 1.879 1.523 3.4 3.4 3.4h.1a1.2 1.2 0 0 1 1.2 1.2v.13c0 .66.54 1.2 1.2 1.2h.1c1.877 0 3.4-1.521 3.4-3.4c0-1.879-1.523-3.4-3.4-3.4H7.9a.1.1 0 0 1-.1-.1v-.2a.1.1 0 0 1 .1-.1h.1c1.877 0 3.4 1.521 3.4 3.4a1.2 1.2 0 0 1-1.2 1.2h-1.2c-.66 0-1.2.54-1.2 1.2v.13c0 1.878 1.523 3.4 3.4 3.4h13.2c1.877 0 3.4-1.522 3.4-3.4">
                        </path>
                    </svg>
                </button>
            </div>
            <!-- Footer Link -->
            <p class="text-center mt-10 text-slate-400 text-sm">
                Don't have an account?
                <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Sign up now</a>
            </p>
        </div>
        <!-- Navigation Bar Indicator (iOS style) -->
        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-32 h-1.5 bg-slate-700/50 rounded-full z-40"></div>
    </div>
    <script>
        const loginForm = document.getElementById('login-form');
        const loginButton = document.getElementById('login-submit');
        const loginText = document.getElementById('login-text');
        const loginSpinner = document.getElementById('login-spinner');

        if (loginForm && loginButton && loginText && loginSpinner) {
            loginForm.addEventListener('submit', () => {
                loginButton.disabled = true;
                loginButton.classList.add('opacity-70', 'cursor-not-allowed');
                loginText.textContent = 'PROCESSING...';
                loginSpinner.classList.remove('hidden');
            });
        }
    </script>
</body>

</html>
