<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        // Допустим, клиент и фрилансер
        return $user->id === $order->client_id
            || $user->id === $order->freelancer_id;
    }

    // Остальные методы...
}


