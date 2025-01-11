<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('jobApplication', 'jobApplication.jobAd', 'client', 'freelancer');
        
        return inertia('Orders/ShowOrder', [
            'order' => $order,
        ]);
    }

// app/Http/Controllers/OrderController.php

public function updateStatus(Request $request, Order $order)
{
    $this->authorize('update', $order);

    $validated = $request->validate([
        'status' => 'required|in:in_progress,completed,cancelled',
    ]);

    // Если заказ уже был отменён или завершён, второй раз менять статус необязательно.
    if (in_array($order->status, ['cancelled', 'completed'])) {
        return back()->withErrors(['message' => 'Order is already completed or cancelled.']);
    }

    // Если пользователь хочет отменить заказ
    if ($validated['status'] === 'cancelled') {
        // Делаем возврат денег клиенту
        $clientBalance = $order->client->balance;
        if (!$clientBalance) {
            return back()->withErrors(['message' => 'Client balance not found.']);
        }

        $price = $order->jobApplication->jobAd->Price;
        $clientBalance->amount += $price;
        $clientBalance->save();

        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Order cancelled and funds have been refunded.');
    }

    if ($validated['status'] === 'completed') {

        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Order completed!');
    }


    $order->status = $validated['status'];
    $order->save();

    return back()->with('success', 'Order status updated!');
}



    public function index(Request $request)
    {
        $user = $request->user();


        $ordersAsClient = $user->ordersAsClient()
            ->with(['jobApplication.jobAd', 'freelancer'])
            ->get();

        $ordersAsFreelancer = $user->ordersAsFreelancer()
            ->with(['jobApplication.jobAd', 'client'])
            ->get();

        return inertia('Orders/Index', [
            'ordersAsClient' => $ordersAsClient,
            'ordersAsFreelancer' => $ordersAsFreelancer,
        ]);
    }
}
