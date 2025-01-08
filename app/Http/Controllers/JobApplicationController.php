<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use App\Models\JobApplication;
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

    /**
     * Сохранение заявки + оплата (без quantity)
     */
    public function store(Request $request, $jobAdId)
    {
        $request->validate([
            // requirements — единственное обязательное поле для заявки
            'requirements' => 'required|string|min:10',
        ]);

        // Находим объявление
        $jobAd = JobAdvertisement::findOrFail($jobAdId);

        // Стоимость — просто Price из объявления
        $total = $jobAd->Price;

        // Проверяем баланс
        $userBalance = auth()->user()->balance;
        if (!$userBalance) {
            return back()->withErrors(['message' => 'Баланс пользователя не найден.']);
        }

        if ($userBalance->amount < $total) {
            return back()->withErrors(['message' => 'Недостаточно средств на балансе.']);
        }

        // Списываем деньги
        $userBalance->amount -= $total;
        $userBalance->save();

        // Создаём заявку
        $jobApplication = JobApplication::create([
            'job_ad_id'    => $jobAd->id,
            'user_id'      => auth()->id(),
            'requirements' => $request->input('requirements'),
        ]);

        // Если хотите уведомить автора объявления
        if ($jobAd->creatorUser) {
            $jobAd->creatorUser->notify(new JobApplicationNotification($jobApplication, auth()->user()));
        }

        // Редирект после успешного создания
        return redirect()
            ->route('jobAds.display', $jobAd->id)
            ->with('success', 'Application submitted and payment processed successfully.');
    }
}
