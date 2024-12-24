<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Avatar;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

class JobAdController extends Controller
{
    /**
     * Отображение формы создания объявления
     */
    public function create()
    {
        return inertia('CreateJobAd'); // Страница для создания объявления
    }

    /**
     * Сохранение нового объявления
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:60',
            'description' => 'required|string|max:1500|min:100',
            'price' => 'required|numeric|min:0',
            'examples' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Вложение (пример работы)
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Загружаем пример работы, если он был загружен
        $exampleFilePath = null;
        if ($request->hasFile('examples')) {
            $exampleFilePath = $request->file('examples')->store('examples', 'public');
        }

        // Сохранение объявления
        $jobAd = new JobAdvertisement();
        $jobAd->title = $request->title;
        $jobAd->description = $request->description;
        $jobAd->price = $request->price;
        $jobAd->examples = $exampleFilePath;
        $jobAd->creator = Auth::user()->name; // Имя создателя
        $jobAd->creator_id = Auth::id(); // ID создателя

        $jobAd->save();

        return redirect()->route('jobAds.index')->with('success', 'Job Ad created successfully.');
    }

    public function destroy(JobAdvertisement $jobAd)
    {
        $jobAd->delete();

        return redirect()->route('jobAds.index')->with('success', 'Job Ad deleted successfully.');
    }

    public function update(Request $request, JobAdvertisement $jobAd)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:60',
            'description' => 'required|string|max:1500|min:100',
            'price' => 'required|numeric|min:0',
            'examples' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $jobAd->title = $validatedData['title'];
        $jobAd->description = $validatedData['description'];
        $jobAd->price = $validatedData['price'];
        $jobAd->creator = Auth::user()->name;
        $jobAd->creator_id = Auth::id();

        if ($request->hasFile('examples')) {
            $jobAd->examples = $request->file('examples')->store('examples', 'public');
        }

        $jobAd->save();

        return redirect()->route('jobAds.index')->with('success', 'Job Ad updated successfully.');
    }

    public function edit(JobAdvertisement $jobAd)
    {
        return inertia('EditJobAd', [
            'jobAd' => $jobAd
        ]);
    }

    public function index()
    {
        $user = Auth::user();

        $jobAds = JobAdvertisement::where('creator_id', $user->id)->get(); // Фильтрация по ID создателя
        return inertia('JobAdInProfile', ['jobAds' => $jobAds]);
    }

}
