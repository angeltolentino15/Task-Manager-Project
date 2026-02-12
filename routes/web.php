<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return response()
        ->view('welcome')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
});

// Redirect Logic after login
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Manage Employees (New Routes added here)
    Route::get('/admin/employee/create', [AdminController::class, 'create'])->name('admin.employee.create');
    Route::post('/admin/employee/store', [AdminController::class, 'store'])->name('admin.employee.store');
    Route::delete('/admin/employee/{user}', [AdminController::class, 'destroy'])->name('admin.employee.destroy');

    // View specific employee tasks
    Route::get('/admin/employee/{id}', [AdminController::class, 'showEmployeeTasks'])->name('admin.employee.tasks');
    
    // Admin Delete Task (Points to the renamed method in AdminController)
    Route::delete('/admin/task/{task}', [AdminController::class, 'destroy'])->name('admin.task.delete');
});


// --- EMPLOYEE ROUTES ---
Route::middleware(['auth', 'role:employee'])->group(function () {
    // Dashboard
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
    
    // Task Actions
    Route::post('/employee/tasks', [EmployeeController::class, 'storeTask'])->name('employee.tasks.store');
});

// --- SHARED TASK ROUTES (For Viewing/Updating/Commenting) ---
// These are available to any logged-in user (but Policies usually protect them)
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/comments', [TaskController::class, 'storeComment'])->name('comments.store');
    
    // Employee Update/Delete (TaskController handles owner checks)
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});


// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';