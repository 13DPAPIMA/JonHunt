<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Review;
use App\Models\Order;

use App\Policies\ReviewPolicy;
use App\Policies\OrderPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Review::class => ReviewPolicy::class,
        Order::class => OrderPolicy::class,

    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
