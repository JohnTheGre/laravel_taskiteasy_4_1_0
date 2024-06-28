<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class HomeController extends Controller
{
    public function index()
    {
        $tasks = Task::all(); // Adjust this as per your data fetching logic
        return view('welcome', compact('tasks'));
    }
}

