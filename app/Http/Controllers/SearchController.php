<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\JobAdvertisement;
use App\Models\User;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');

        if (strlen($query) < 2) {
            return Inertia::render('SearchPage', [
                'query' => $query,
                'users' => [],
                'projects' => [],
                'jobAds' => [],
            ]);
        }

        // Поиск по пользователям (по имени или username)
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('username', 'like', "%$query%")
            ->with('avatar') // Предзагрузка аватара
            ->take(5)
            ->get();

        // Поиск по проектам
        $projects = Project::where('title', 'like', "%$query%")
            ->with(['creator' => function ($query) {
                $query->select('id', 'name', 'username', 'avatar'); // Загружаем создателя проекта с его аватаром
            }])
            ->take(5)
            ->get();

        // Поиск по объявлениям
        $jobAds = JobAdvertisement::where('title', 'like', "%$query%")
            ->with(['creator' => function ($query) {
                $query->select('id', 'name', 'username', 'avatar'); // Загружаем создателя объявления с его аватаром
            }])
            ->take(5)
            ->get();

        return Inertia::render('SearchPage', [
            'query' => $query,
            'users' => $users,
            'projects' => $projects,
            'jobAds' => $jobAds,
        ]);
    }
}
