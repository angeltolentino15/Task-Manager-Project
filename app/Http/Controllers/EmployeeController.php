<?php

namespace App\Http\Controllers; // <--- This was missing!

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class EmployeeController extends Controller
{
    // 1. SHOW THE DASHBOARD
    public function index()
    {
        return view('employee.dashboard');
    }

    // 2. SAVE THE TASK
    public function storeTask(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        // Create the task in the database
        Task::create([
            'user_id' => auth()->id(), // Assigns it to the logged-in employee
            'title' => $request->title,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        // Refresh the page with a success message
        return redirect()->back()->with('success', 'Task added successfully!');
    }
}