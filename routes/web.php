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
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
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
    
    // Manage Employees
    Route::get('/admin/employee/create', [AdminController::class, 'create'])->name('admin.employee.create');
    Route::post('/admin/employee/store', [AdminController::class, 'store'])->name('admin.employee.store');
    Route::delete('/admin/employee/{user}', [AdminController::class, 'destroy'])->name('admin.employee.destroy');

    // View specific employee tasks
    Route::get('/admin/employee/{id}', [AdminController::class, 'showEmployeeTasks'])->name('admin.employee.tasks');
    
    // Admin Task Management
    Route::delete('/admin/task/{task}', [AdminController::class, 'destroy'])->name('admin.task.delete');
    Route::get('/admin/tasks/create', [AdminController::class, 'createTask'])->name('admin.tasks.create');
    Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
});


// --- EMPLOYEE ROUTES ---
Route::middleware(['auth', 'role:employee'])->group(function () {
    // Dashboard & Create Task
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::post('/employee/tasks', [EmployeeController::class, 'storeTask'])->name('employee.tasks.store');
});


// --- SHARED TASK ROUTES ---
// Available to logged-in users. 
Route::middleware(['auth'])->group(function () {
    
    // 1. UPDATE & DELETE (Mapped to EmployeeController for Dashboard Functionality)
    // We point these to EmployeeController so the Dashboard buttons work immediately
    Route::patch('/tasks/{id}', [EmployeeController::class, 'updateStatus'])->name('tasks.update');
    Route::delete('/tasks/{id}', [EmployeeController::class, 'destroy'])->name('tasks.destroy');

    // 2. VIEW DETAILS & COMMENTS (Kept on TaskController if you have a separate view)
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/comments', [TaskController::class, 'storeComment'])->name('comments.store');
});


// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';