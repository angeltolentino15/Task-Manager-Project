<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tasks for: <span class="text-blue-600">{{ $employee->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.dashboard') }}" class="inline-block mb-4 text-gray-600 hover:text-gray-900">
                &larr; Back to Employee List
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($employee->tasks->isEmpty())
                    <p class="text-gray-500 text-center py-4">This employee has no tasks yet.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status (Update Here)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($employee->tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $task->title }}
                                        <div class="text-gray-400 text-xs font-normal mb-1">{{ Str::limit($task->description, 50) }}</div>
                                        
                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs underline">
                                            View Details / Comment
                                        </a>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                            @csrf 
                                            @method('PATCH')
                                            
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cursor-pointer 
                                                {{ $task->status == 'Done' ? 'text-green-700 bg-green-50' : ($task->status == 'In Progress' ? 'text-blue-700 bg-blue-50' : 'text-gray-700') }}">
                                                
                                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No Date' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.task.delete', $task->id) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>