@extends('admin.layout')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Users</h2>
    </div>
    <div class="overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-sm">
            <thead class="bg-white/5 text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Joined</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @foreach ($users as $user)
                    <tr class="hover:bg-white/5">
                        <td class="px-4 py-3 font-semibold">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $user->is_admin ? 'bg-primary/20 text-primary' : 'bg-slate-800 text-slate-300' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-primary font-semibold hover:underline"
                                href="{{ route('admin.users.edit', $user) }}">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" class="inline-block"
                                method="POST" onsubmit="return confirm('Delete this user?');">
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
        {{ $users->links() }}
    </div>
@endsection
