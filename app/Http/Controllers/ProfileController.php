<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user(); 
    
        
        $user->fill($request->validated());
    
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    

        $user->save();
    
       
        return Redirect::route('profile.edit');
    }


    public function uploadAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
    
        if ($request->hasFile('avatar')) {
            // Сохраняем файл в папку storage/app/public/avatar
            $avatarPath = $request->file('avatar')->store('public/avatar');
            
            // Получаем полный путь к файлу, включая storage/app/public
            $avatarFullPath = Storage::url($avatarPath);
            
            // Сохраняем полный путь к файлу в базе данных
            $user->avatar = $avatarFullPath;
            $user->save();
        }
    
        return Redirect::route('profile.edit');
    }


    public function show($userId)
    {
        $user = User::findOrFail($userId);

        // Предполагается, что в модели пользователя есть поле 'avatar', 
        // которое содержит путь к изображению аватара в хранилище
        $avatarPath = $user->avatar;

        // Проверяем, существует ли файл изображения
    if (Storage::exists($avatarPath)) {
        // Если файл существует, возвращаем его в качестве ответа
        return response()->file(storage_path('app/' . $avatarPath));
    } else {
        // Если файл не существует, возвращаем ошибку 404
        abort(404);
    }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
