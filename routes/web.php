<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/*
 * The home routes
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
 * The protected home route
 */
Route::middleware(['auth'])->get('/home', [TaskController::class, 'index'])->name('home');


/*
 * The dashboard route
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
 * The resource routes
 */
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::resource('posts', PostController::class);
    Route::resource('projects', ProjectController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('comments.store');
    Route::middleware(['auth'])->group(function () {
        Route::resource('posts', PostController::class);

        Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])
            ->name('comments.store')
            ->middleware('role:post_viewer');
    });
});

/*
 * Route that shows the about page. This handler just returns the about view.
 */
Route::view('/about', 'about')->name('about');

if (App::environment('production')) {
    URL::forceScheme('https');
}

require __DIR__.'/auth.php';
