<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Project;
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
    

    public function show($username)
{
    // Получение данных пользователя
    $user = User::where('username', $username)->firstOrFail();

    // Получение проектов, в которых пользователь участвует
    $projects = Project::where('id', $user->id)->get(); // Предполагается, что есть связь между проектами и пользователем

    // Возврат данных во Vue-компонент
    return Inertia::render('UserProfile', [
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => [
                'photo_url' => $user->avatar,
            ],
            'role' => $user->role,
            'description' => $user->description,
        ],
        'projects' => $projects,
    ]);
}
    
 
    public function myProfile()
    {
        $user = Auth::user();

        return inertia('UserProfile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'description' => $user->description,
                'avatar' => $user->avatar, // Убедись, что аватар доступен
                'user' => Auth::user(),
            ],
            'freelancerData' => $user->role === 'freelancer' ? $user->freelancerProfile : null,
        ]);
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
