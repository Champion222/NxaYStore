@extends('admin.layout')

@section('content')
    <div class="max-w-xl">
        <h2 class="text-2xl font-bold mb-6">Edit User</h2>
        <form action="{{ route('admin.users.update', $user) }}" class="space-y-4" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label class="text-sm text-slate-400">Name</label>
                <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
                    name="name" type="text" value="{{ old('name', $user->name) }}" />
            </div>
            <div>
                <label class="text-sm text-slate-400">Email</label>
                <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
                    name="email" type="email" value="{{ old('email', $user->email) }}" />
            </div>
            <div class="flex items-center gap-3">
                <input class="w-5 h-5 rounded border-white/10 bg-white/10 text-primary" id="is_admin"
                    name="is_admin" type="checkbox" value="1" {{ $user->is_admin ? 'checked' : '' }} />
                <label class="text-sm text-slate-400" for="is_admin">Admin user</label>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-6 py-3 rounded-xl bg-primary text-white font-semibold" type="submit">Save</button>
                <a class="text-slate-400 hover:text-white" href="{{ route('admin.users.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
