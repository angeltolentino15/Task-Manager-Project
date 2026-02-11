<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
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
    // Admin viewing a specific employee's tasks
    Route::get('/admin/employee/{id}', [AdminController::class, 'showEmployeeTasks'])->name('admin.employee.tasks');
    // Admin deleting a task
    Route::delete('/admin/task/{id}', [TaskController::class, 'destroy'])->name('admin.task.delete');
});


// --- EMPLOYEE ROUTES ---
Route::middleware(['auth'])->group(function () {
    Route::get('/my-dashboard', [TaskController::class, 'index'])->name('employee.dashboard');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

// ---PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
