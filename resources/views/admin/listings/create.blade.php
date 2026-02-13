@extends('admin.layout')

@section('content')
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold mb-6">Create Listing</h2>
        <form action="{{ route('admin.listings.store') }}" class="space-y-6" method="POST">
            @csrf
            @include('admin.listings._form', ['listing' => new \App\Models\Listing()])
            <div class="flex items-center gap-3">
                <button class="px-6 py-3 rounded-xl bg-primary text-white font-semibold" type="submit">Create</button>
                <a class="text-slate-400 hover:text-white" href="{{ route('admin.listings.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
