@extends('admin.layout')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Orders</h2>
    </div>
    <div class="overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-sm">
            <thead class="bg-white/5 text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left">Order #</th>
                    <th class="px-4 py-3 text-left">Buyer</th>
                    <th class="px-4 py-3 text-left">Listing</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @foreach ($orders as $order)
                    <tr class="hover:bg-white/5">
                        <td class="px-4 py-3 font-semibold">{{ $order->order_number ?? $order->id }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $order->user?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $order->listing?->title ?? 'Custom Order' }}</td>
                        <td class="px-4 py-3 text-slate-300">
                            {{ number_format($order->total_amount, 2) }} {{ strtoupper($order->currency) }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $order->status === 'completed' ? 'bg-emerald-500/20 text-emerald-400' : ($order->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-slate-800 text-slate-300') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-primary font-semibold hover:underline"
                                href="{{ route('admin.orders.edit', $order) }}">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" class="inline-block"
                                method="POST" onsubmit="return confirm('Delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 font-semibold hover:underline ml-3" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
