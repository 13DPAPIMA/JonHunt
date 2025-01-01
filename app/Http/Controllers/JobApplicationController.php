<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Notifications\JobApplicationNotification;
use Illuminate\Support\Facades\Auth;




class JobApplicationController extends Controller
{
    public function create($jobAdId)
    {
        $jobAd = JobAdvertisement::findOrFail($jobAdId);
        return inertia('JobApplication', [
            'jobAd' => $jobAd,
        ]);
    }

    public function store(Request $request, $jobAdId)
    {
        $request->validate([
            'requirements' => 'required|string|min:10',
        ]);
    
        $jobAd = JobAdvertisement::findOrFail($jobAdId);
    
        $jobApplication = JobApplication::create([
            'job_ad_id' => $jobAd->id,
            'user_id' => auth()->id(),
            'requirements' => $request->requirements,
        ]);
    
        if ($jobAd->creatorUser) {
            $jobAd->creatorUser->notify(new JobApplicationNotification($jobApplication, auth()->user()));
        }
        
            
        return redirect()->route('jobAds.display', $jobAdId)->with('success', 'Application submitted successfully.');
    }
    

    public function display()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        \Log::info(auth()->user()->notifications()->latest()->get());

        return Inertia::render('AuthenticatedLayout', [
            'notifications' => $notifications,
        ]);
    }
    

}
