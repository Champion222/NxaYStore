@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? 'Nexus';
    $brandAccent = $brand['accent'] ?? 'Market';
    $brandIcon = $brand['logo_icon'] ?? 'sports_esports';
    $user = $user ?? auth()->user();
    $userInitial = $user ? strtoupper(substr($user->name, 0, 1)) : 'U';
    $avatarUrl = $user && $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
    $showProfile = $showProfile ?? false;
@endphp
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white neon-glow">
            <span class="material-icons text-2xl">{{ $brandIcon }}</span>
        </div>
        <h1 class="text-xl font-bold tracking-tight">{{ $brandName }}{{ $brandAccent }}</h1>
    </div>
    <div class="flex items-center gap-3">
        <button class="w-10 h-10 rounded-full bg-slate-200 dark:bg-primary/10 flex items-center justify-center"
            type="button">
            <span class="material-icons text-xl">notifications</span>
        </button>
        @if ($showProfile)
            <a class="flex items-center" href="{{ route('profile') }}">
                <div
                    class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary/30 bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center">
                    @if ($avatarUrl)
                        <img alt="{{ $user?->name }} avatar" class="w-full h-full object-cover"
                            src="{{ $avatarUrl }}" />
                    @else
                        <span class="text-sm font-bold text-primary">{{ $userInitial }}</span>
                    @endif
                </div>
            </a>
        @endif
    </div>
</div>
