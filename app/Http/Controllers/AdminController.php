<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. DASHBOARD WITH STATISTICS
    public function index()
    {
        // Fetch all employees
        $employees = User::where('role', 'employee')->get();
        
        // Calculate counts for the dashboard cards
        $totalEmployees = $employees->count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $InProgress = Task::where('status', 'In Progress')->count();      
        $completedTasks = Task::where('status', 'Done')->count();


        return view('admin.dashboard', compact('employees', 'totalEmployees', 'pendingTasks', 'InProgress', 'completedTasks'));
    }

    // 2. VIEW SPECIFIC EMPLOYEE TASKS
    public function showEmployeeTasks($id)
    {
        $employee = User::with('tasks')->findOrFail($id);

    // Count how many tasks are marked as "Pending"
        $pendingCount = $employee->tasks->where('status', 'Pending')->count();
        
    // Count In Progress
        $progressCount = $employee->tasks->where('status', 'In Progress')->count();

        return view('admin.employee-tasks', compact('employee', 'pendingCount', 'progressCount'));
    }

    // 3. SHOW CREATE USER FORM
    public function create() 
    {
        return view('admin.create-user');
    }

    // 4. STORE NEW USER
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'department' => 'required',
            'position' => 'required',
            'phone_number' => 'required', 
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'position' => $request->position,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'employee', 
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User added successfully!');
    }

    // 5. DELETE USER ACCOUNT
    public function destroy(User $user)
    {
        // Prevent admin from deleting their own account
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User account deleted successfully.');
    }

    // 6. DELETE SPECIFIC TASK (Renamed to avoid conflict)
    public function delete(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}