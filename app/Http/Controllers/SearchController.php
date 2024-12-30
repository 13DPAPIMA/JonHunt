<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\JobAdvertisement;
use App\Models\User;
use App\Models\Freelancer;
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
                'freelancers' => [],
            ]);
        }

        // Поиск по пользователям (по имени или username)
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('username', 'like', "%$query%")
            ->with('avatar') // Предзагрузка аватара
            ->take(5)
            ->get();

        // Поиск по фрилансерам (по навыкам, имени, username или специализации)
        $freelancers = Freelancer::whereHas('user', function ($userQuery) use ($query) {
                $userQuery->where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%");
            })
            ->orWhere('specialization', 'like', "%$query%")
            ->orWhereHas('skills', function ($skillQuery) use ($query) {
                $skillQuery->where('name', 'like', "%$query%");
            })
            ->with(['user.avatar', 'skills']) // Предзагрузка пользователя, аватара и навыков
            ->take(5)
            ->get();

        // Поиск по проектам (по названию, нише, имени создателя или username создателя)
        $projects = Project::where('title', 'like', "%$query%")
            ->orWhere('niche', 'like', "%$query%")
            ->orWhereHas('creator', function ($creatorQuery) use ($query) {
                $creatorQuery->where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%");
            })
            ->with(['creator.avatar']) // Загружаем создателя проекта с его аватаром
            ->take(5)
            ->get();

        // Поиск по объявлениям (по названию, имени создателя или username создателя)
        $jobAds = JobAdvertisement::where('title', 'like', "%$query%")
            ->orWhereHas('creator', function ($creatorQuery) use ($query) {
                $creatorQuery->where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%");
            })
            ->with(['creator.avatar']) // Загружаем создателя объявления с его аватаром
            ->take(5)
            ->get();

        // Формирование ответа для фронтенда
        return Inertia::render('SearchPage', [
            'query' => $query,
            'users' => $users,
            'freelancers' => $freelancers,
            'projects' => $projects,
            'jobAds' => $jobAds,
        ])->with('debug', [
            'jobAdsCount' => $jobAds->count(),
            'projectsCount' => $projects->count(),
            'freelancersCount' => $freelancers->count(),
            'usersCount' => $users->count(),
        ]);
    }
}
