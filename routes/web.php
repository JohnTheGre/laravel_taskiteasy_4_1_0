<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
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
 * The resource routes
 */
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::resource('posts', PostController::class);
    Route::resource('projects', ProjectController::class);
});

/*
 * Route that shows the about page. This handler just returns the about view.
 */
Route::view('/about', 'about')->name('about');

URL::forceScheme('https');
require __DIR__.'/auth.php';


