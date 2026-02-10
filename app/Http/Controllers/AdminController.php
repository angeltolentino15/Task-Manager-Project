<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all employees (exclude admins)
        $employees = User::where('role', 'employee')->get();
        return view('admin.dashboard', compact('employees'));
    }

    public function showEmployeeTasks($id)
    {
        $employee = User::with('tasks')->findOrFail($id);
        return view('admin.employee-tasks', compact('employee'));
    }
}