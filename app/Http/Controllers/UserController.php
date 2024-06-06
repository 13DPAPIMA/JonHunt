<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\User;
use App\Models\Project;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use App\Models\Review;

class UserController extends Controller
{
    /**
     * Display the user's projects.
     */
    public function projectsInProfile(): Response
    {
        $user = Auth::user();
        $projects = Project::where('creator', $user->email)->get();
        

        return Inertia::render('ProjectsInProfile', [
            'projects' => $projects,
        ]);

    }

    /**
     * Show the form for editing the specified project.
     */
    public function editProject(Request $request, Project $project): Response
    {
        return Inertia::render('EditProject', [
            'project' => $project,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }
    
    /**
     * Update the specified project in storage.
     */
    public function updateProject(Request $request, Project $project)
    {
        $user = Auth::user();
    
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200|min:60',
            'desc' => 'required|string|max:1500|min:100',
            'niche' => 'required|string|in:Technology,Health,Education,Finance,Entertainment',
            'completion_date' => 'required|date|after_or_equal:today|before_or_equal:' . Carbon::now()->addYear()->toDateString(),
            'budget' => 'required|numeric|min:0',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $validatedData = $validator->validated();

    $project->title = $validatedData['title'];
    $project->description = $validatedData['desc'];
    $project->niche = $validatedData['niche'];
    $project->completion_date = $validatedData['completion_date'];
    $project->budget = $validatedData['budget'];
    $project->creator = $user->email;
    
        $project->save();
    

    }
    
  
    public function delete(Request $request, Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.'], 200);
    }


    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function services(User $user)
    {
        $services = $user->services()->paginate(10);
        return view('user.services', compact('user', 'services'));
    }

    public function profile(User $user)
{
    return view('user.profile', compact('user'));
}
}
