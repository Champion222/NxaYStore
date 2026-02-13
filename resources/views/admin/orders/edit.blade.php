@extends('admin.layout')

@section('content')
    <div class="max-w-xl">
        <h2 class="text-2xl font-bold mb-6">Edit Order</h2>
        <form action="{{ route('admin.orders.update', $order) }}" class="space-y-4" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label class="text-sm text-slate-400">Order #</label>
                <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
                    type="text" value="{{ $order->order_number ?? $order->id }}" disabled />
            </div>
            <div>
                <label class="text-sm text-slate-400">Status</label>
                <select class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
                    name="status">
                    @foreach (['pending', 'completed', 'canceled', 'disputed'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-6 py-3 rounded-xl bg-primary text-white font-semibold" type="submit">Save</button>
                <a class="text-slate-400 hover:text-white" href="{{ route('admin.orders.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
