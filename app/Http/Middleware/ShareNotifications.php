<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShareNotifications
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Проверяем, авторизован ли пользователь
        if (Auth::check()) {
            // Получаем уведомления текущего пользователя
            $notifications = Auth::user()->notifications()->latest()->get();

            // Делаем уведомления доступными во всех Inertia страницах
            Inertia::share('notifications', $notifications);
        } else {
            // Если пользователь не авторизован, уведомления не передаются
            Inertia::share('notifications', []);
        }

        return $next($request);
    }
}
