<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/projects/create', function () {
    return Inertia::render('CreateProject');
})->middleware(['auth', 'verified'])->name('/projects/create');



Route::get('/dashboard', [ProjectsController::class, 'display'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::post('/profile', [ProfileController::class, 'uploadAvatar'])->name('avatar.upload');
Route::get('/avatar/{userId}', [ProfileController::class, 'show'])->name('avatar.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/addReview', [ProjectsController::class, 'addReview'])->name('projects.addReview');
    Route::post('/reviews/{review}/edit', [ProjectsController::class, 'editReview'])->name('reviews.edit');
    Route::delete('/reviews/{review}', [ProjectsController::class, 'deleteReview'])->name('reviews.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects-in-profile', [UserController::class, 'projectsInProfile'])->name('projects.inProfile');
    Route::get('/projects/edit/{project}', [UserController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/update/{project}', [UserController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [UserController::class, 'delete'])->name('projects.delete');
});

Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/services', [UserController::class, 'services'])->name('user.services');
Route::get('/user/{user}', [UserController::class, 'profile'])->name('user.profile');

require __DIR__.'/auth.php';