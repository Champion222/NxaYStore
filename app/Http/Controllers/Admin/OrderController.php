<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['user', 'listing'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', [
            'brand' => $this->brand(),
            'orders' => $orders,
        ]);
    }

    public function edit(Order $order): View
    {
        return view('admin.orders.edit', [
            'brand' => $this->brand(),
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,completed,canceled,disputed'],
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Order updated.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Order deleted.');
    }
}
