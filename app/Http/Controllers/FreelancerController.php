<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->freelancer) {
            return response()->json(['message' => 'You are already registered as a freelancer.'], 422);
        }
    
        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'specialization' => [
                'required', 'string', 'max:255',
                Rule::in([
                    'Web Development',
                    'Graphic Design',
                    'Content Writing',
                    'Digital Marketing',
                    'SEO',
                    'Mobile App Development',
                    'UI/UX Design',
                ]),
            ],
            'experience' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:1',
            'portfolio' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'skills' => 'array|max:5', 
            'skills.*' => 'string|exists:skills,name', 
        ]);
    
        $user = Auth::user();
    
        // Создаем запись для фрилансера
        $freelancer = Freelancer::create([
            'user_id' => $user->id,
            'country' => $validatedData['country'],
            'bio' => $validatedData['bio'],
            'experience' => $validatedData['experience'],
            'specialization' => $validatedData['specialization'],
            'hourly_rate' => $validatedData['hourly_rate'],
            'portfolio' => $request->file('portfolio') ? $request->file('portfolio')->store('portfolios', 'public') : null,
        ]);
    
        // Привязка навыков
        if (isset($validatedData['skills'])) {
            $skillIds = Skill::whereIn('name', $validatedData['skills'])->pluck('id');
            \Log::info('Skills to attach:', $skillIds->toArray());
            $freelancer->skills()->sync($skillIds);
            \Log::info('Attached skills:', $freelancer->skills()->pluck('id')->toArray());
        }
    
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
        \Log::info('Received update request', $request->all());

        $freelancer = Auth::user()->freelancer;

        $validatedData = $request->validate([
            'country' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'required|string|max:255',
            Rule::in([
                'Web Development',
                'Graphic Design',
                'Content Writing',
                'Digital Marketing',
                'SEO',
                'Mobile App Development',
                'UI/UX Design',
            ]),
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

            if (isset($validatedData['skills'])) {
                $skillIds = Skill::whereIn('name', $validatedData['skills'])->pluck('id');
                $freelancer->skills()->sync($skillIds);
            }

            \Log::info('Updated freelancer', $freelancer->toArray());

            return redirect()->route('freelancers.show', $username)->with('success', 'Profile updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to update freelancer profile', ['error' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred while updating the profile. Please try again later.']);
        }
    }


    public function getFreelancerProfile($id)
    {
        $freelancer = Freelancer::with('user')->findOrFail($id);
        return response()->json(['freelancer' => $freelancer]);
    }
}
