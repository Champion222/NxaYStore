<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Listing;
use App\Models\Order;

class PageController extends Controller
{
    public function home(): View
    {
        $popularListings = Listing::query()
            ->where('status', 'active')
            ->whereNotNull('category')
            ->latest()
            ->take(3)
            ->get();

        $featuredListings = Listing::query()
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        return view('components.home', [
            'brand' => $this->brand(),
            'popularListings' => $popularListings,
            'featuredListings' => $featuredListings,
        ]);
    }

    public function market(): View
    {
        $listings = Listing::query()
            ->where('status', 'active')
            ->latest()
            ->take(24)
            ->get();

        return view('market', [
            'brand' => $this->brand(),
            'listings' => $listings,
        ]);
    }

    public function orders(): View
    {
        $orders = Order::query()
            ->with('listing')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $counts = [
            'pending' => $orders->where('status', 'pending')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'disputed' => $orders->where('status', 'disputed')->count(),
        ];

        return view('orders', [
            'brand' => $this->brand(),
            'orders' => $orders,
            'counts' => $counts,
        ]);
    }
}
