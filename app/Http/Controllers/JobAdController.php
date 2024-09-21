<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobAdController extends Controller
{
    /**
     * Отображение формы создания объявления
     */
    public function create()
    {
        return inertia('CreateJobAd');  // Страница для создания объявления
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
        $jobAd->creator = Auth::user()->name;  // ID текущего пользователя

        $jobAd->save();

    }

}
