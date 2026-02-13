<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class EmployeeController extends Controller
{
    /**
     * 1. SHOW THE DASHBOARD
     * Connects to: view('employee.dashboard')
     */
    public function index()
    {
        // Get the currently logged-in user's ID
        $userId = Auth::id();
        
        // 1. Get tasks for the logged-in employee
        // Ordered by due_date (asc) so urgent tasks appear first
        $tasks = Task::where('user_id', $userId)
                     ->orderBy('due_date', 'asc') 
                     ->get();

        // 2. Count the stats for the "Statistics Cards" in the dashboard
        // Used in Blade: {{ $pendingCount }}
        $pendingCount = Task::where('user_id', $userId)
                            ->where('status', 'Pending')
                            ->count();
        
        // Used in Blade: {{ $progressCount }}
        $progressCount = Task::where('user_id', $userId)
                             ->where('status', 'In Progress')
                             ->count();

        // 3. Return the specific view file
        // Ensure your blade file is located at: resources/views/employee/dashboard.blade.php
        return view('employee.dashboard', compact('tasks', 'pendingCount', 'progressCount'));
    }

    /**
     * 2. SAVE THE TASK
     * Connects to Blade Form: <form action="{{ route('employee.tasks.store') }}" ...>
     */
    public function storeTask(Request $request)
    {
        // Validation
        // Note: 'description' is validated here, but your Blade form currently 
        // only has 'title' and 'due_date'. This is fine (it will just be null).
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', 
            'due_date' => 'nullable|date',
        ]);

        // Create the new Task
        $task = new Task();
        $task->user_id = Auth::id(); // Assign to logged-in user
        $task->title = $request->title;
        $task->description = $request->description; 
        $task->due_date = $request->due_date;
        $task->status = 'Pending'; // Default status for new tasks

        $task->save();

        // Redirect back to the dashboard with a success message
        return redirect()->route('employee.dashboard')->with('success', 'Task added successfully!');
    }

    /**
     * 3. UPDATE TASK STATUS (Added to support your Blade Dashboard)
     * Connects to Blade: <select onchange="this.form.submit()">
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate that the status is one of the allowed options
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Done',
        ]);

        // Find the task and ensure it belongs to the logged-in user
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        // Update the status
        $task->status = $request->status;
        $task->save();

        // Redirect back (maintains the scroll position usually)
        return redirect()->back()->with('success', 'Task status updated!');
    }

    /**
     * 4. DELETE TASK (Added to support your Blade Dashboard)
     * Connects to Blade: <form action="{{ route('tasks.destroy', $task->id) }}" ...>
     */
    public function destroy($id)
    {
        // Find the task and ensure it belongs to the logged-in user
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        // Delete the task
        $task->delete();

        // Redirect back to dashboard
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}