@extends('admin.layout')

@section('content')
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
            <p class="text-xs uppercase tracking-widest text-slate-400">Users</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['users'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
            <p class="text-xs uppercase tracking-widest text-slate-400">Listings</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['listings'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
            <p class="text-xs uppercase tracking-widest text-slate-400">Orders</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['orders'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
            <p class="text-xs uppercase tracking-widest text-slate-400">Pending Orders</p>
            <p class="text-3xl font-bold mt-2 text-yellow-400">{{ $stats['pending_orders'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
            <p class="text-xs uppercase tracking-widest text-slate-400">Completed Orders</p>
            <p class="text-3xl font-bold mt-2 text-emerald-400">{{ $stats['completed_orders'] ?? 0 }}</p>
        </div>
    </div>
@endsection
