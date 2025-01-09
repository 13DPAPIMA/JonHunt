<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('jobApplication', 'client', 'freelancer');
        
        return inertia('Orders/ShowOrder', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'required|in:in_progress,completed,cancelled',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return back()->with('success', 'Order status updated!');
    }
}
