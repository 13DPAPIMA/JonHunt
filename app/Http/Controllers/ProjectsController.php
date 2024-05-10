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


class ProjectsController extends Controller
{
    /**
     * Display the form for creating a new project.
     */
    public function create(): Response
    {
        return view('projects.create'); // Предположим, что у вас есть шаблон для формы создания проекта
    }

    /**
     * Store a newly created project in storage.
     */

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200|min:60',
            'desc' => 'required|string|max:1500|min:100',
            'niche' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $project = new Project();
        $project->title = $validatedData['title'];
        $project->description = $validatedData['desc'];
        if (isset($validatedData['niche'])) {
            $project->niche = $validatedData['niche'];
        }
        $project->creator = Auth::user()->email;

        $project->save();
    }


}