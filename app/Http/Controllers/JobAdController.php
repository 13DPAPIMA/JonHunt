<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use Illuminate\Http\Request;
use App\Models\JobAdvertisementPortfolio;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Controllers\JobAdvertisementPortfolioController;
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
            'title'        => 'required|string|max:35|min:35',
            'description'  => 'required|string|max:1500|min:100',
            'price'        => 'required|numeric|min:0',
    
            // Множественная валидация: каждый элемент массива examples должен быть файлом
            'examples.*'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // 1. Сохраняем объявление
        $jobAd = new JobAdvertisement();
        $jobAd->title       = $request->title;
        $jobAd->description = $request->description;
        $jobAd->price       = $request->price;
        $jobAd->creator     = Auth::user()->name;
        $jobAd->creator_id  = Auth::id();
        $jobAd->save(); 
    
        
        if ($request->hasFile('examples')) {
            $files = $request->file('examples');
    
            foreach ($files as $file) {
                $result = Cloudinary::uploadFile($file->getRealPath(), [
                    'folder' => 'job-portfolio/' . Auth::id(),
                ]);
    
                // Сохраняем связанный портфолио-запись
                JobAdvertisementPortfolio::create([
                    'job_ad_id'         => $jobAd->id,
                    'example_url'       => $result->getSecurePath(),
                    'example_public_id' => $result->getPublicId(),
                ]);
            }
        }
    
        return redirect()->route('jobAds.index')->with('success', 'Job Ad created successfully.');
    }

    public function destroy(JobAdvertisement $jobAd)
    {
        $jobAd->delete();

        return redirect()->route('jobAds.index')->with('success', 'Job Ad deleted successfully.');
    }

    public function updateImage(Request $request, JobAdvertisement $jobAd)
    {
        $validator = Validator::make($request->all(), [
            'examples' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Удаление старого примера
        $oldExample = JobAdvertisementPortfolio::where('job_ad_id', $jobAd->id)->first();
    
        if ($oldExample) {
            try {
                Cloudinary::destroy($oldExample->example_public_id);
                $oldExample->delete();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to delete old example', 'error' => $e->getMessage()], 500);
            }
        }
    
        // Загрузка нового примера
        $file = $request->file('examples');
        $result = Cloudinary::uploadFile($file->getRealPath(), [
            'folder' => 'job-portfolio/' . Auth::id(),
        ]);
    
        $newExample = JobAdvertisementPortfolio::create([
            'job_ad_id' => $jobAd->id,
            'example_url' => $result->getSecurePath(),
            'example_public_id' => $result->getPublicId(),
        ]);
    
        return response()->json(['example_url' => $newExample->example_url]);
    }
    


    public function update(Request $request, JobAdvertisement $jobAd)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:35|min:10',
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
            $oldExamples = JobAdvertisementPortfolio::where('job_ad_id', $jobAd->id)->get();

            foreach ($oldExamples as $example) {
                try {
                    Cloudinary::destroy($example->example_public_id);
                    $example->delete();
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to delete old example files: ' . $e->getMessage());
                }
            }

            $files = $request->file('examples');

            foreach ($files as $file) {
                try {
                    $result = Cloudinary::uploadFile($file->getRealPath(), [
                        'folder' => 'job-portfolio/' . Auth::id(),
                    ]);

                    JobAdvertisementPortfolio::create([
                        'job_ad_id'         => $jobAd->id,
                        'example_url'       => $result->getSecurePath(),
                        'example_public_id' => $result->getPublicId(),
                    ]);
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to upload new example files: ' . $e->getMessage());
                }
            }
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

    public function display(JobAdvertisement $jobAds) 
    {
        $jobAds->load('creator.avatar');
        
        return Inertia::render('JobAdsPage', [
            'jobAds' => $jobAds,
        ]);

    }

}
