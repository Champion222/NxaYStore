<div class="grid gap-4 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="text-sm text-slate-400">Title</label>
        <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="title" type="text" value="{{ old('title', $listing->title ?? '') }}" />
    </div>
    <div class="md:col-span-2">
        <label class="text-sm text-slate-400">Description</label>
        <textarea class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white" name="description"
            rows="3">{{ old('description', $listing->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="text-sm text-slate-400">Category</label>
        <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="category" type="text" value="{{ old('category', $listing->category ?? '') }}" />
    </div>
    <div>
        <label class="text-sm text-slate-400">Seller</label>
        <select class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="user_id">
            <option value="">Unassigned</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ (int) old('user_id', $listing->user_id ?? 0) === $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-sm text-slate-400">Price</label>
        <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="price" step="0.01" type="number" value="{{ old('price', $listing->price ?? '') }}" />
    </div>
    <div>
        <label class="text-sm text-slate-400">Currency</label>
        <select class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="currency">
            <option value="USD" {{ old('currency', $listing->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
            <option value="KHR" {{ old('currency', $listing->currency ?? 'USD') === 'KHR' ? 'selected' : '' }}>KHR</option>
        </select>
    </div>
    <div>
        <label class="text-sm text-slate-400">Stock</label>
        <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="stock" type="number" value="{{ old('stock', $listing->stock ?? 1) }}" />
    </div>
    <div>
        <label class="text-sm text-slate-400">Status</label>
        <select class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="status">
            <option value="active" {{ old('status', $listing->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $listing->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm text-slate-400">Image URL</label>
        <input class="mt-2 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
            name="image_url" type="url" value="{{ old('image_url', $listing->image_url ?? '') }}" />
    </div>
</div>
