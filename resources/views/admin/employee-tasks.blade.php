{{-- Main application layout wrapper --}}
<x-app-layout>
    {{-- Header slot with employee name --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            Tasks for: <span class="text-blue-600">{{ $employee->name }}</span>
        </h2>
    </x-slot>

    {{-- Main content area --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Top Navigation and Statistics Bar --}}
            <div class="flex justify-between items-center mb-6">
                
                {{-- Back to Employee List Link --}}
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition flex items-center">
                    <span class="mr-2 text-lg">&larr;</span> Back to Employee List
                </a>

                {{-- Statistics Cards Container --}}
                <div class="flex gap-4">
                    
                    {{-- Pending Tasks Count Card - Red themed --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-3 border-l-4 border-red-400 flex flex-col justify-center min-w-[150px]">
                        <div class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-wider">
                            Pending Tasks
                        </div>
                        <div class="text-xl font-extrabold text-red-500 leading-none mt-1">
                            {{ $pendingCount }} <span class="text-xs font-normal text-gray-600 dark:text-gray-400 ml-1">Waiting</span>
                        </div>
                    </div>

                    {{-- In Progress Tasks Count Card - Yellow themed --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-3 border-l-4 border-yellow-400 flex flex-col justify-center min-w-[150px]">
                        <div class="text-gray-500 dark:text-gray-400 text-[10px] font-bold uppercase tracking-wider">
                            In Progress
                        </div>
                        <div class="text-xl font-extrabold text-yellow-500 leading-none mt-1">
                            {{ $progressCount }} <span class="text-xs font-normal text-gray-600 dark:text-gray-400 ml-1">Active</span>
                        </div>
                    </div>

                </div> 
            </div>
            
            {{-- Tasks Table Container --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Empty State - Shown when employee has no tasks --}}
                @if($employee->tasks->isEmpty())
                    <p class="text-gray-500 text-center py-4">This employee has no tasks yet.</p>
                @else
                    {{-- Tasks Table --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        {{-- Table Header --}}
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status (Update Here)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        
                        {{-- Table Body --}}
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Loop through each task --}}
                            @foreach($employee->tasks as $task)
                                <tr>
                                    {{-- Task Title and Description Column --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{-- Task Title --}}
                                        {{ $task->title }}
                                        {{-- Task Description Preview (limited to 50 characters) --}}
                                        <div class="text-gray-400 text-xs font-normal mb-1">{{ Str::limit($task->description, 50) }}</div>
                                        
                                        {{-- View Details Link --}}
                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs underline">
                                            View Details / Comment
                                        </a>
                                    </td>
                                    
                                    {{-- Status Update Column with Auto-Submit Form --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                            @csrf 
                                            @method('PATCH')
                                            
                                            {{-- Status Dropdown - Auto-submits on change --}}
                                            {{-- Dynamic styling based on current status --}}
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cursor-pointer 
                                                {{ $task->status == 'Done' ? 'text-green-700 bg-green-50' : ($task->status == 'In Progress' ? 'text-blue-700 bg-blue-50' : 'text-gray-700') }}">
                                                
                                                {{-- Status Options --}}
                                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Due Date Column - Formatted or 'No Date' fallback --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No Date' }}
                                    </td>
                                    
                                    {{-- Actions Column - Delete Task --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Delete Task Form with Confirmation Dialog --}}
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