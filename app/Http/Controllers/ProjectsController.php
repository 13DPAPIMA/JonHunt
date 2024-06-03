<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use App\Models\Review;



class ProjectsController extends Controller
{
    /**
     * Display the form for creating a new project.
     */
    public function create(): Response
{
    $niches = ['Technology', 'Health', 'Education', 'Finance', 'Entertainment'];

    return Inertia::render('projects.create', [
        'niches' => $niches,
    ]);
}

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200|min:60',
            'desc' => 'required|string|max:1500|min:100',
            'niche' => 'required|string|in:Technology,Health,Education,Finance,Entertainment',
            'completion_date' => 'required|date|after_or_equal:today|before_or_equal:' . Carbon::now()->addYear()->toDateString(),
            'budget' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $project = new Project();
        $project->title = $validatedData['title'];
        $project->description = $validatedData['desc'];
        $project->niche = $validatedData['niche'];
        $project->completion_date = $validatedData['completion_date'];
        $project->budget = $validatedData['budget'];
        
        $project->creator = Auth::user()->email;

        $project->save();
    }
    
    public function display()
{
  $projects = Project::all();

  return Inertia::render('Dashboard', [
    'projects' => $projects, 
  ]);
}
public function show(Project $project)
{
    $project->load('reviews.user');

    return Inertia::render('ProjectsPage', [
        'project' => $project,
        'reviews' => $project->reviews,
    ]);
}

public function addReview(Request $request, Project $project)
{
    $validated = $request->validate([
        'Rating' => 'required|integer|between:1,5',
        'ReviewText' => 'nullable|string|max:1000',
    ]);

    
    $reviewedUserId = $project->creator;

    $review = new Review();
    $review->project_id = $project->id;
    $review->UserID = Auth::id();
    $review->ReviewedUserID = $reviewedUserId;
    $review->Rating = $validated['Rating'];
    $review->ReviewText = $validated['ReviewText'];
    $review->save();

    return redirect()->route('projects.show', $project->id)->with('success', 'Review added successfully.');
}

public function deleteReview(Request $request, Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()->route('projects.show', $review->project_id)->with('success', 'Review deleted successfully.');
    }

    public function editReview(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'Rating' => 'required|integer|between:1,5',
            'ReviewText' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('projects.show', $review->project_id)->with('success', 'Review updated successfully.');
    }
}

