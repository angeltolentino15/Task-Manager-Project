<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // Show only the tasks assigned to the logged-in employee
        $tasks = Auth::user()->tasks;
        return view('employee.dashboard', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $request->user()->tasks()->create($validated);
        return back();
    }

    public function update(Request $request, Task $task)
    {
        // Simple status toggle for demonstration
        $task->update($request->all());
        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }
}
