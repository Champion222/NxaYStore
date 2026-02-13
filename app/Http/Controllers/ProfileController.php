<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();

        $listings = Listing::query()
            ->where('user_id', $user?->id)
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $totalOrders = Order::query()
            ->whereHas('listing', function ($query) use ($user) {
                $query->where('user_id', $user?->id);
            })
            ->count();

        $completedOrders = Order::query()
            ->whereHas('listing', function ($query) use ($user) {
                $query->where('user_id', $user?->id);
            })
            ->where('status', 'completed')
            ->count();

        $trustScore = $totalOrders > 0 ? (int) round(($completedOrders / $totalOrders) * 100) : 100;

        return view('profile', [
            'brand' => $this->brand(),
            'user' => $user,
            'listings' => $listings,
            'stats' => [
                'trust_score' => $trustScore,
                'total_sales' => $completedOrders,
                'joined' => $user?->created_at?->format('Y') ?? now()->format('Y'),
                'active_listings' => $listings->count(),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('avatar')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('status', 'Profile updated.');
    }

}
