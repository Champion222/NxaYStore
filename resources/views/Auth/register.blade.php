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
    <title>User Registration - {{ $brandFull }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
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
                        "accent-purple": "#8b5cf6",
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
        }

        .ios-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .form-glow:focus-within {
            box-shadow: 0 0 15px rgba(43, 75, 238, 0.3);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen flex flex-col items-center">
    <div
        class="relative flex h-full min-h-screen w-full max-w-[430px] flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">
        <!-- Header Image Section -->
        <div class="relative h-[280px] w-full overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" data-alt="Cinematic gaming setup with neon lighting"
                style="background-image: linear-gradient(to bottom, rgba(16, 19, 34, 0.2), rgba(16, 19, 34, 1)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuAeFtbLPs2mLKEGtW_PJodOrU_puaeYctFhK6-IGiNP0FCE_PuQhmBg7EC1CuCYCndVnQT7FBZV_wcki0FOwCvYD-odZ22iNu3_LV6gy2poCIfHiEZGjMg7jN-bHFLmfUI0Cl9Z6BBXYg3Nljw3J9wOmo692m5yM989dsBzhxrUOmjsz-KrQmZo-1FsZ-DTyeQAFHAnnYs5mfjwadl1ygvygc8F_fValuGX3mjNeKFvdy1nPun7WnbnPh62IHg7AKfyqXec8hSwOkYz');">
            </div>
            <!-- Top Navigation -->
            <div class="relative flex items-center justify-between p-6 pt-12">
                <button
                    class="flex size-10 items-center justify-center rounded-full bg-background-dark/40 border border-white/10 text-white ios-blur">
                    <span class="material-symbols-outlined">arrow_back_ios_new</span>
                </button>
                <div
                    class="flex size-10 items-center justify-center rounded-full bg-background-dark/40 border border-white/10 text-white ios-blur">
                    <span class="material-symbols-outlined">help_outline</span>
                </div>
            </div>
            <!-- Welcome Text -->
            <div class="relative px-6 mt-8">
                <h1 class="text-4xl font-bold tracking-tight text-white">Join {{ $brandName }}</h1>
                <p class="mt-2 text-slate-300 font-medium">Create your profile to start trading.</p>
            </div>
        </div>
        <!-- Registration Form Section -->
        <div class="flex-1 px-6 pb-12 -mt-4 relative z-10 bg-background-dark rounded-t-xl">
            <h2 class="text-xl font-bold pt-8 pb-6">Level Up Your Experience</h2>
            <form action="{{ route('register.perform') }}" class="space-y-4" id="register-form" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        <p class="font-semibold">Registration failed</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Username -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-400 px-1">Username</label>
                    <div class="relative flex items-center group form-glow rounded-full">
                        <span
                            class="material-symbols-outlined absolute left-4 text-slate-500 group-focus-within:text-primary transition-colors">person</span>
                        <input
                            class="w-full h-14 pl-12 pr-4 bg-slate-900/50 border border-slate-800 rounded-full text-white placeholder:text-slate-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                            name="name" placeholder="Enter your gaming alias" type="text"
                            value="{{ old('name') }}" />
                    </div>
                </div>
                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-400 px-1">Email Address</label>
                    <div class="relative flex items-center group form-glow rounded-full">
                        <span
                            class="material-symbols-outlined absolute left-4 text-slate-500 group-focus-within:text-primary transition-colors">mail</span>
                        <input
                            class="w-full h-14 pl-12 pr-4 bg-slate-900/50 border border-slate-800 rounded-full text-white placeholder:text-slate-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                            name="email" placeholder="email@example.com" type="email" value="{{ old('email') }}" />
                    </div>
                </div>
                <!-- Password -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-400 px-1">Password</label>
                    <div class="relative flex items-center group form-glow rounded-full">
                        <span
                            class="material-symbols-outlined absolute left-4 text-slate-500 group-focus-within:text-primary transition-colors">lock</span>
                        <input
                            class="w-full h-14 pl-12 pr-12 bg-slate-900/50 border border-slate-800 rounded-full text-white placeholder:text-slate-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                            name="password" placeholder="••••••••" type="password" />
                        <span
                            class="material-symbols-outlined absolute right-4 text-slate-500 cursor-pointer">visibility</span>
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-400 px-1">Confirm Password</label>
                    <div class="relative flex items-center group form-glow rounded-full">
                        <span
                            class="material-symbols-outlined absolute left-4 text-slate-500 group-focus-within:text-primary transition-colors">verified_user</span>
                        <input
                            class="w-full h-14 pl-12 pr-4 bg-slate-900/50 border border-slate-800 rounded-full text-white placeholder:text-slate-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                            name="password_confirmation" placeholder="••••••••" type="password" />
                    </div>
                </div>
                <!-- Toggle Selector: I want to Buy/Sell -->
                <div class="flex flex-col gap-2 pt-4">
                    <label class="text-sm font-semibold text-slate-400 px-1">I want to:</label>
                    <div class="flex bg-slate-900/50 border border-slate-800 p-1 rounded-full h-12">
                        <button
                            class="flex-1 flex items-center justify-center rounded-full bg-primary text-white font-bold text-sm transition-all shadow-lg shadow-primary/20"
                            type="button">
                            Buy Services
                        </button>
                        <button
                            class="flex-1 flex items-center justify-center rounded-full text-slate-400 font-bold text-sm hover:text-white transition-all"
                            type="button">
                            Sell Services
                        </button>
                    </div>
                </div>
                <!-- Terms Checkbox -->
                <div class="flex items-start gap-3 px-1 pt-2">
                    <div class="relative flex items-center h-5 mt-1">
                        <input
                            class="w-5 h-5 rounded bg-slate-900 border-slate-800 text-primary focus:ring-offset-background-dark focus:ring-primary"
                            id="terms" type="checkbox" />
                    </div>
                    <label class="text-sm text-slate-400 leading-snug" for="terms">
                        I agree to the <a class="text-primary hover:underline" href="#">Terms of Service</a> and
                        <a class="text-primary hover:underline" href="#">Privacy Policy</a>
                    </label>
                </div>
                <!-- Action Button -->
                <div class="pt-6">
                    <button
                        class="w-full h-16 bg-primary hover:bg-primary/90 text-white text-lg font-bold rounded-full shadow-xl shadow-primary/30 flex items-center justify-center gap-2 transition-all active:scale-[0.98]"
                        id="register-submit" type="submit">
                        <span id="register-text">Create Account</span>
                        <span class="material-symbols-outlined" id="register-icon">rocket_launch</span>
                        <span class="material-symbols-outlined hidden animate-spin" id="register-spinner">progress_activity</span>
                    </button>
                </div>
                <!-- Divider -->
                <div class="relative flex items-center py-4">
                    <div class="flex-grow border-t border-slate-800"></div>
                    <span class="flex-shrink mx-4 text-xs font-bold text-slate-600 uppercase tracking-widest">Or Sign Up
                        with</span>
                    <div class="flex-grow border-t border-slate-800"></div>
                </div>
                <!-- Social Icons -->
                <div class="flex justify-center gap-4">
                    <button
                        class="flex items-center justify-center size-12 rounded-full border border-slate-800 bg-slate-900/50 hover:bg-slate-800 transition-colors"
                        type="button">
                        <svg class="w-5 h-5" fill="#5865F2" viewbox="0 0 24 24">
                            <path
                                d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.419 0 1.334-.947 2.419-2.157 2.419zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.419 0 1.334-.946 2.419-2.157 2.419z">
                            </path>
                        </svg>
                    </button>
                    <button
                        class="flex items-center justify-center size-12 rounded-full border border-slate-800 bg-slate-900/50 hover:bg-slate-800 transition-colors"
                        type="button">
                        <svg class="w-5 h-5" viewbox="0 0 24 24">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4"></path>
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853"></path>
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                fill="#FBBC05"></path>
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12-4.53z"
                                fill="#EA4335"></path>
                        </svg>
                    </button>
                </div>
                <!-- Login Redirect -->
                <div class="text-center pt-8">
                    <p class="text-slate-400">Already have an account? <a class="text-primary font-bold"
                            href="{{ route('login') }}">Log In</a></p>
                </div>
            </form>
        </div>
        <!-- Bottom Safe Area Spacer -->
        <div class="h-8 bg-background-dark"></div>
    </div>
    <script>
        const registerForm = document.getElementById('register-form');
        const registerButton = document.getElementById('register-submit');
        const registerText = document.getElementById('register-text');
        const registerIcon = document.getElementById('register-icon');
        const registerSpinner = document.getElementById('register-spinner');

        if (registerForm && registerButton && registerText && registerSpinner) {
            registerForm.addEventListener('submit', () => {
                registerButton.disabled = true;
                registerButton.classList.add('opacity-70', 'cursor-not-allowed');
                registerText.textContent = 'CREATE...';
                if (registerIcon) {
                    registerIcon.classList.add('hidden');
                }
                registerSpinner.classList.remove('hidden');
            });
        }
    </script>
</body>

</html>

