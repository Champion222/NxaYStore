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
    <title>{{ $brandFull }} - Verify Email</title>
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
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center overflow-hidden">
    <div class="relative w-full h-screen max-w-md bg-background-dark overflow-hidden flex flex-col">
        <div class="relative h-[35%] w-full">
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/40 to-transparent z-10">
            </div>
            <div class="absolute inset-0 bg-primary/20 mix-blend-multiply z-10"></div>
            <img alt="Email verification background" class="absolute inset-0 w-full h-full object-cover"
                data-alt="Futuristic gaming scene"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTVYRYjgWmNbOw4DHa5BXZguQFnIuFKIioMPExdp-i3_JQwmHI23cN5yz4TdBGAPeAYpAn1GCP1h8qPxwm15sufMhXkwvZ5XoOMm2zrJVLSgOUe9PXr5BLjkse7_52AqxCngJhWnDqIjVxWJuWGbhoF2Yr3_Re3bA95uSLLgf1ZDWgMidf9pC6yIY4zIzIF4GsToF4ZJSGuvefC8xCxrqZesxq1KDbl2mLanUxNHAgvRGdRs4Phyebr3nPEXoZpQmWe9cmcwkH26qU" />
            <div class="relative z-20 flex flex-col items-center justify-center h-full pt-8">
                <div
                    class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/40 mb-3">
                    <span class="material-icons text-white text-3xl">{{ $brandIcon }}</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-white">
                    {{ $brandName }}<span class="text-primary">{{ $brandAccent }}</span>
                </h1>
                <p class="text-slate-300 text-xs font-medium mt-1">{{ $brandTagline }}</p>
            </div>
        </div>
        <div class="relative z-30 flex-1 bg-background-dark px-8 pt-8 pb-12 rounded-t-xl -mt-6">
            <div class="w-12 h-1.5 bg-slate-700/50 rounded-full mx-auto mb-8"></div>
            <header class="mb-6">
                <h2 class="text-2xl font-bold">Verify your email</h2>
                <p class="text-slate-400 text-sm">Enter the 6-digit code we sent to your email.</p>
            </header>
            <form action="{{ route('verification.verify') }}" class="space-y-5" id="verify-form" method="POST">
                @csrf
                @if (session('status'))
                    <div class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        <p class="font-semibold">Verification failed</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <span
                            class="material-icons text-slate-500 group-focus-within:text-primary transition-colors text-xl">verified</span>
                    </div>
                    <input
                        class="w-full bg-slate-800/50 border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-full py-4 pl-12 pr-4 text-white placeholder:text-slate-500 transition-all duration-300 outline-none text-center tracking-[0.5em]"
                        name="code" placeholder="------" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                        autocomplete="one-time-code" />
                </div>
                <button
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-full shadow-lg shadow-primary/30 active:scale-95 transition-all duration-200 mt-2 flex items-center justify-center gap-2"
                    id="verify-submit" type="submit">
                    <span id="verify-text">VERIFY {{ $brandFullUpper }}</span>
                    <span class="material-icons hidden animate-spin" id="verify-spinner">progress_activity</span>
                </button>
            </form>
            <form action="{{ route('verification.resend') }}" class="mt-6" method="POST">
                @csrf
                <button class="w-full text-sm font-semibold text-primary hover:text-primary/80" type="submit">
                    Resend code
                </button>
            </form>
            <p class="text-center mt-8 text-slate-400 text-sm">
                Need a different email? <a class="text-primary font-bold hover:underline" href="{{ route('profile') }}">
                    Update profile
                </a>
            </p>
        </div>
    </div>
    <script>
        const verifyForm = document.getElementById('verify-form');
        const verifyButton = document.getElementById('verify-submit');
        const verifyText = document.getElementById('verify-text');
        const verifySpinner = document.getElementById('verify-spinner');

        if (verifyForm && verifyButton && verifyText && verifySpinner) {
            verifyForm.addEventListener('submit', () => {
                verifyButton.disabled = true;
                verifyButton.classList.add('opacity-70', 'cursor-not-allowed');
                verifyText.textContent = 'VERIFY...';
                verifySpinner.classList.remove('hidden');
            });
        }
    </script>
</body>

</html>
