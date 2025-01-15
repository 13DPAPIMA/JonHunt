<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use App\Models\Skill;
use App\Models\PortfolioPhoto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class FreelancerController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
    
        // Сразу проверяем: если уже фрилансер, выбрасываем ошибку
        if ($user->role === 'freelancer' || $user->freelancer) {
            return response()->json([
                'message' => 'You are already registered as a freelancer.'
            ], 422);
        }
    
        // Если мы дошли сюда — пользователь ещё не фрилансер.
        // Дальше идёт валидация и создание записи
        $validatedData = $request->validate([
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
            'experience_from' => 'required|integer|min:1900|max:2100',
            'experience_to' => 'nullable|integer|min:1900|max:2100',
            'skills' => 'array|max:5',
            'skills.*' => 'string|exists:skills,name',
        ]);
    
        $freelancer = Freelancer::create([
            'user_id'         => $user->id,
            'country'         => $validatedData['country'],
            'bio'             => $validatedData['bio'],
            'specialization'  => $validatedData['specialization'],
            'experience_from' => $validatedData['experience_from'],
            'experience_to'   => $validatedData['experience_to'] ?? null,
        ]);
    
        if (!empty($validatedData['skills'])) {
            $skillIds = Skill::whereIn('name', $validatedData['skills'])->pluck('id');
            $freelancer->skills()->sync($skillIds);
        }
    
        // Обновляем роль
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
            'portfolio_photos.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'hourly_rate' => 'required|numeric|min:1',
            'portfolio' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('portfolio_photos')) {
            foreach ($freelancer->portfolioPhotos as $photo) {
                \Cloudinary::destroy($photo->cloudinary_public_id);
                $photo->delete();
            }
    
            foreach ($request->file('portfolio_photos') as $photo) {
                $result = \Cloudinary::upload($photo->getRealPath(), [
                    'folder' => 'freelancers/portfolios',
                ]);
    
                PortfolioPhoto::create([
                    'freelancer_id' => $freelancer->id,
                    'photo_url' => $result->getSecurePath(),
                    'cloudinary_public_id' => $result->getPublicId(),
                ]);
            }
        }
    

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
