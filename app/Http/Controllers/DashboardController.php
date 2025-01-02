<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\JobAdvertisement;
use App\Notifications\JobApplicationNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Inertia\Response
     */
    public function display()
    {
        $projects = Project::with('creator.avatar')->get();
        $jobAds = JobAdvertisement::with('creator.avatar')->get();
        $notifications = auth()->user()->notifications()->latest()->get();
        \Log::info(auth()->user()->notifications()->latest()->get());

        return Inertia::render('Dashboard', [
            'projects' => $projects,
            'jobAds' => $jobAds,
            'notifications' => $notifications,
        ]);
    }

}
