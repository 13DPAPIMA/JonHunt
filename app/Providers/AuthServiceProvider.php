<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Review;
use App\Policies\ReviewPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Review::class => ReviewPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
