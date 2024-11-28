<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->freelancer) {
            return response()->json(['message' => 'You are already registered as a freelancer.'], 422);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'required|string|max:255',
            'experience' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:1',
            'portfolio' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        if ($user->freelancer) {
            return response()->json(['error' => 'You are already a freelancer!'], 400);
        }

        $freelancer = Freelancer::create([
            'user_id' => $user->id,
            'country' => $request->country,
            'bio' => $request->bio,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'hourly_rate' => $request->hourly_rate,
            'portfolio' => $request->file('portfolio') ? $request->file('portfolio')->store('portfolios', 'public') : null,
        ]);

        $user->update(['role' => 'freelancer']);


        return response()->json(['message' => 'You are now a freelancer!']);

    }



    public function edit($username)
{
    $user = Auth::user();
    
    if ($user->username !== $username) {
        abort(403, 'You are not authorized to edit this profile.');
    }

    $freelancer = $user->freelancer;

    return inertia('EditFreelanceProfile', [
        'freelancer' => $freelancer,
        'user' => $user->only(['id', 'username', 'name', 'email']),
    ]);

}

public function update(Request $request, $username)
{
    // Лог входящих данных
    \Log::info('Received update request', $request->all());

    $freelancer = Auth::user()->freelancer;

    // Валидация данных
    $validatedData = $request->validate([
        'country' => 'required|string|max:255',
        'bio' => 'nullable|string|max:1000',
        'specialization' => 'required|string|max:255',
        'experience' => 'nullable|string|max:1000',
        'hourly_rate' => 'required|numeric|min:1',
        'portfolio' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
    ]);

    try {
        $freelancer->update([
            'country' => $validatedData['country'],
            'bio' => $validatedData['bio'],
            'specialization' => $validatedData['specialization'],
            'experience' => $validatedData['experience'],
            'hourly_rate' => $validatedData['hourly_rate'],
            'portfolio' => $request->file('portfolio')
                ? $request->file('portfolio')->store('portfolios', 'public')
                : $freelancer->portfolio,
        ]);

        \Log::info('Updated freelancer', $freelancer->toArray());

        return redirect()->route('freelancers.show', $username)->with('success', 'Profile updated successfully.');

    } catch (\Exception $e) {
        \Log::error('Failed to update freelancer profile', ['error' => $e->getMessage()]);
        return back()->withErrors(['general' => 'An error occurred while updating the profile. Please try again later.']);
    }
}




public function show($username)
{
    $user = User::where('username', $username)->firstOrFail();
    
    if (!$user->freelancer) {
        abort(404, 'Freelancer profile not found.');
    }

    $freelancer = $user->freelancer;

    return inertia('FreelancerProfile', [
        'freelancer' => $freelancer,
        'user' => $user,
    ]);
}



public function getFreelancerProfile($id)
{
    $freelancer = Freelancer::with('user')->findOrFail($id);
    return response()->json(['freelancer' => $freelancer]);
}
}
