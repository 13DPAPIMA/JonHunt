<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\JobAdController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\FreelancerController;



use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jobAdvertisements', [JobAdController::class, 'index'])->name('jobAds.index');  // Просмотр всех объявлений пользователя
    Route::get('/jobAdvertisements/create', [JobAdController::class, 'create'])->name('jobAds.create');  // Форма создания
    Route::post('/jobAdvertisements', [JobAdController::class, 'store'])->name('jobAds.store');  // Сохранение нового объявления
    Route::get('/jobAdvertisements/{jobAd}/edit', [JobAdController::class, 'edit'])->name('jobAds.edit');  // Страница редактирования
    Route::put('/jobAdvertisements/{jobAd}', [JobAdController::class, 'update'])->name('jobAds.update');  // Обновление
    Route::delete('/jobAdvertisements/delete/{jobAd}', [JobAdController::class, 'destroy'])->name('jobAds.delete');
});

Route::get('/freelancer-registration', function () {
    return inertia('FreelancerRegistration');
})->name('freelancer.registration');

Route::post('/api/become-freelancer', [FreelancerController::class, 'store'])->name('freelancer.store');

Route::get('/freelancer/{username}/edit', [FreelancerController::class, 'edit'])->name('freelancers.edit');
Route::put('/freelancer/{username}/update', [FreelancerController::class, 'update'])->name('freelancers.update');


Route::get('/projects/create', function () {
    return Inertia::render('CreateProject');
})->middleware(['auth', 'verified'])->name('/projects/create');



Route::middleware(['auth', 'verified' ])->group(function () {
    Route::get('/dashboard', [ProjectsController::class, 'display'])->name('dashboard');
});


Route::get('/guest', [GuestController::class, 'dashboard'])->name('guest.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile.my')->middleware('auth');
    Route::get('/users/{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/avatar/upload', [PhotoController::class, 'uploadPhoto'])->name('avatar.upload');
Route::delete('/avatar/delete', [PhotoController::class, 'deleteAvatar'])->name('avatar.delete');
Route::get('/avatar', [PhotoController::class, 'getAvatar'])->name('avatar.get');

Route::get('/profile/avatar', [PhotoController::class, 'getAvatar'])->name('avatar.get');

Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/addReview', [App\Http\Controllers\ReviewsController::class, 'addReview'])->name('reviews.addReview');
    Route::post('/reviews/{review}/edit', [App\Http\Controllers\ReviewsController::class, 'editReview'])->name('reviews.edit');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewsController::class, 'deleteReview'])->name('reviews.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects-in-profile', [UserController::class, 'projectsInProfile'])->name('projects.inProfile');
    Route::get('/projects/edit/{project}', [UserController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/update/{project}', [UserController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/delete/{project}', [UserController::class, 'delete'])->name('projects.delete');
});

Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/services', [UserController::class, 'services'])->name('user.services');
Route::get('/user/{user}', [UserController::class, 'profile'])->name('user.profile');

require __DIR__.'/auth.php';