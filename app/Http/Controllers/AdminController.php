<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\JobAdvertisement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Главная страница админ-панели (dashboard).
     */
    public function index(): \Inertia\Response
    {

        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalJobAds = JobAdvertisement::count();

        return Inertia::render('Admin/AdminDashboard', [
            'totalUsers' => $totalUsers,
            'totalProjects' => $totalProjects,
            'totalJobAds' => $totalJobAds,
        ]);
    }

    /**
     * Список всех пользователей.
     */
    public function usersIndex(): \Inertia\Response
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/UsersIndex', [
            'users' => $users
        ]);
    }

    /**
     * Удаление пользователя.
     */
    public function usersDestroy($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Пользователь успешно удалён!');
    }

    /**
     * Список всех проектов.
     */
    public function projectsIndex(): \Inertia\Response
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/ProjectsIndex', [
            'projects' => $projects
        ]);
    }

    /**
     * Удаление проекта.
     */
    public function projectsDestroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Проект удалён!');
    }

    /**
     * Список всех объявлений о работе.
     */
    public function jobAdsIndex(): \Inertia\Response
    {
        $jobAds = JobAdvertisement::orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/JobAdsIndex', [
            'jobAds' => $jobAds
        ]);
    }

    /**
     * Удаление объявления о работе.
     */
    public function jobAdsDestroy(JobAdvertisement $jobAd)
    {
        $jobAd->delete();

        return back()->with('success', 'Объявление о работе удалено!');
    }

    /**
     * Личная страница администратора (профиль).
     */
    public function profile(): \Inertia\Response
    {
        $admin = auth()->user(); 

        return Inertia::render('Admin/Profile', [
            'admin' => $admin
        ]);
    }
}
