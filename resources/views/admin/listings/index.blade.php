@extends('admin.layout')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Listings</h2>
        <a class="px-4 py-2 rounded-xl bg-primary text-white font-semibold" href="{{ route('admin.listings.create') }}">
            New Listing
        </a>
    </div>
    <div class="overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-sm">
            <thead class="bg-white/5 text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Seller</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @foreach ($listings as $listing)
                    <tr class="hover:bg-white/5">
                        <td class="px-4 py-3 font-semibold">{{ $listing->title }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $listing->seller?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-300">
                            {{ number_format($listing->price, 2) }} {{ strtoupper($listing->currency) }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $listing->status === 'active' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-800 text-slate-300' }}">
                                {{ ucfirst($listing->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-primary font-semibold hover:underline"
                                href="{{ route('admin.listings.edit', $listing) }}">Edit</a>
                            <form action="{{ route('admin.listings.destroy', $listing) }}" class="inline-block"
                                method="POST" onsubmit="return confirm('Delete this listing?');">
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
        {{ $listings->links() }}
    </div>
@endsection
