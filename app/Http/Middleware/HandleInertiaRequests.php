<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Avatar;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request)
    {
        // Берём пользователя из сессии
        $user = $request->user();

        // Переменная под аватар (по умолчанию null)
        $avatar = null;

        // Если пользователь залогинен
        if ($user) {
            // Подгружаем отношение avatar, если нужно
            $user->load('avatar');

            // Явно получаем аватар из базы (или через связь)
            $avatar = Avatar::where('user_id', $user->id)->first();
            // или, если связь точно работает, можно сразу:
            // $avatar = $user->avatar;
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ? [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                    'balance' => $request->user()->balance->amount ?? 0, 
                    'avatar' => $avatar ? [
                        'photo_url'             => $avatar->photo_url,
                        'cloudinary_public_id'  => $avatar->cloudinary_public_id,
                    ] : null,
                ] : null,
            ],
        ]);
    }

}
