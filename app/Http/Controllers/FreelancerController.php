<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
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

    public function getFreelancerProfile($id)
    {
        $freelancer = Freelancer::with('user')->findOrFail($id);
        return response()->json(['freelancer' => $freelancer]);
    }
}
