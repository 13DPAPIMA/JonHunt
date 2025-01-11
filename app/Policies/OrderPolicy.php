<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        return $user->id === $order->client_id
            || $user->id === $order->freelancer_id;
    }

    public function update(User $user, Order $order)
    {
        return $user->id === $order->client_id
            || $user->id === $order->freelancer_id;
    }

}


