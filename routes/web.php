<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\JobAdController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobAdvertisementPortfolioController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/user/{username}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/projects/create', function () {
    return Inertia::render('CreateProject');
})->name('/projects/create');

Route::get('/projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');

Route::get('/gigs/{jobAds}', [JobAdController::class, 'display'])->name('jobAds.display');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jobAdvertisements', [JobAdController::class, 'index'])->name('jobAds.index');
    Route::get('/jobAdvertisements/create', [JobAdController::class, 'create'])->name('jobAds.create');
    Route::post('/jobAdvertisements', [JobAdController::class, 'store'])->name('jobAds.store');
    Route::get('/jobAdvertisements/{jobAd}/edit', [JobAdController::class, 'edit'])->name('jobAds.edit');
    Route::put('/jobAdvertisements/{jobAd}', [JobAdController::class, 'update'])->name('jobAds.update');
    Route::delete('/jobAdvertisements/delete/{jobAd}', [JobAdController::class, 'destroy'])->name('jobAds.delete');
    

    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::post('/projects/{project}/addReview', [App\Http\Controllers\ReviewsController::class, 'addReview'])->name('reviews.addReview');
    Route::post('/reviews/{review}/edit', [App\Http\Controllers\ReviewsController::class, 'editReview'])->name('reviews.edit');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewsController::class, 'deleteReview'])->name('reviews.delete');

    Route::get('/projects-in-profile', [UserController::class, 'projectsInProfile'])->name('projects.inProfile');
    Route::get('/projects/edit/{project}', [UserController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/update/{project}', [UserController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/delete/{project}', [UserController::class, 'delete'])->name('projects.delete');

    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile.my');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/avatar/upload', [PhotoController::class, 'uploadPhoto'])->name('avatar.upload');
    Route::delete('/avatar/delete', [PhotoController::class, 'deleteAvatar'])->name('avatar.delete');

    Route::get('/jobs/{jobAd}/apply', [JobApplicationController::class, 'create'])->name('jobApplications.create');
    Route::post('/jobs/{jobAd}/apply', [JobApplicationController::class, 'store'])->name('jobApplications.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/freelancer-registration', function () {
        return inertia('FreelancerRegistration');
    })->name('freelancer.registration');
    Route::post('/api/become-freelancer', [FreelancerController::class, 'store'])->name('freelancer.store');
    Route::get('/freelancer/{username}/edit', [FreelancerController::class, 'edit'])->name('freelancers.edit');
    Route::put('/freelancer/{username}/update', [FreelancerController::class, 'update'])->name('freelancers.update');
});

Route::post('/notifications/mark-all-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth');

Route::middleware(['share.notifications'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'display'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/portfolio', [JobAdvertisementPortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio', [JobAdvertisementPortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}', [JobAdvertisementPortfolioController::class, 'show'])->name('portfolio.show');
    Route::delete('/portfolio/{portfolio}', [JobAdvertisementPortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::put('/portfolio/{portfolio}', [JobAdvertisementPortfolioController::class, 'update'])->name('portfolio.update');
});


Route::get('/dashboard', [DashboardController::class, 'display'])->name('dashboard');

use App\Http\Controllers\BalanceController;

Route::middleware(['auth'])->group(function () {
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
    Route::post('/balance', [BalanceController::class, 'store'])->name('balance.store');
});


use App\Http\Controllers\OrderController;

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/submit-work', [OrderController::class, 'submitWork'])->name('orders.submit-work');
    Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
});


use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::delete('/delete/user/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

        // Projects
        Route::get('/projects', [AdminController::class, 'projectsIndex'])->name('projects.index');
        Route::delete('/delete/projects/{project}', [AdminController::class, 'projectsDestroy'])->name('projects.destroy');

        // Job Ads
        Route::get('/job-ads', [AdminController::class, 'jobAdsIndex'])->name('jobAds.index');
        Route::delete('/delete/job-ads/{jobAd}', [AdminController::class, 'jobAdsDestroy'])->name('jobAds.destroy');

    });

require __DIR__.'/auth.php';
