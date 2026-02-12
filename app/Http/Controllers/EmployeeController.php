<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class EmployeeController extends Controller
{
    // 1. SHOW THE DASHBOARD
    public function index()
    {
        // Fetch only the tasks belonging to the logged-in employee
        $tasks = Task::where('user_id', auth()->id())->get();

        // Pass the $tasks variable to the view
        return view('employee.dashboard', compact('tasks'));
    }

    // 2. SAVE THE TASK (Merged & Updated)
    public function storeTask(Request $request)
    {
        // Combined validation: Added file rules and string constraints
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Initialize the Task object
        $task = new Task();
        $task->user_id = auth()->id();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->status = 'pending'; // Keeps the default status from your 2nd snippet

        // Handle File Upload if an attachment exists
        if ($request->hasFile('attachment')) {
            // Stores in storage/app/public/attachments
            $path = $request->file('attachment')->store('attachments', 'public');
            $task->attachment = $path;
        }

        $task->save();

        // Return with a success message
        return redirect()->back()->with('success', 'Task added successfully!');
    }
}