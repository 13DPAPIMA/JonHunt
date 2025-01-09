<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use App\Models\JobApplication;
use App\Models\Order;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use App\Notifications\JobApplicationNotification;

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

        $total = $jobAd->Price;

        $userBalance = auth()->user()->balance;
        if (!$userBalance) {
            return back()->withErrors(['message' => 'Баланс пользователя не найден.']);
        }

        if ($userBalance->amount < $total) {
            return back()->withErrors(['message' => 'Недостаточно средств на балансе.']);
        }

        $userBalance->amount -= $total;
        $userBalance->save();

        $jobApplication = JobApplication::create([
            'job_ad_id'    => $jobAd->id,
            'user_id'      => auth()->id(),
            'requirements' => $request->input('requirements'),
        ]);

        if ($jobAd->creatorUser) {
            $jobAd->creatorUser->notify(new JobApplicationNotification($jobApplication, auth()->user()));
        }

        $order = Order::create([
            'job_application_id' => $jobApplication->id,
            'client_id' => auth()->id(),           
            'freelancer_id' => $jobAd->creator_id, 
            'status' => 'in_progress',
        ]);
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order created and payment processed successfully!');
    }
}
