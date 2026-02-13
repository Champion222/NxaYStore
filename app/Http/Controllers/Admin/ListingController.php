<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(): View
    {
        $listings = Listing::query()->with('seller')->latest()->paginate(12);

        return view('admin.listings.index', [
            'brand' => $this->brand(),
            'listings' => $listings,
        ]);
    }

    public function create(): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('admin.listings.create', [
            'brand' => $this->brand(),
            'users' => $users,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'in:USD,KHR'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        Listing::create($validated);

        return redirect()
            ->route('admin.listings.index')
            ->with('status', 'Listing created.');
    }

    public function edit(Listing $listing): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('admin.listings.edit', [
            'brand' => $this->brand(),
            'listing' => $listing,
            'users' => $users,
        ]);
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'in:USD,KHR'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $listing->update($validated);

        return redirect()
            ->route('admin.listings.index')
            ->with('status', 'Listing updated.');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->delete();

        return redirect()
            ->route('admin.listings.index')
            ->with('status', 'Listing deleted.');
    }
}
