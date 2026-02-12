<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Task;

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

    public function destroy(Task $task)
    {
        // Delete the task
        $task->delete();

        // Refresh the page with a success message
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}