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
            
{{-- Tasks List Container (Replaces Table) --}}
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-200 dark:border-gray-800">
                
                {{-- Empty State --}}
                @if($employee->tasks->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center py-6 italic">This employee has no tasks yet.</p>
                @else
                    {{-- List Wrapper --}}
                    <div class="flex flex-col">
                        @foreach($employee->tasks as $task)
                            {{-- Single Task Card --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-6 border-b border-gray-200 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition px-2 -mx-2 rounded-lg">
                                
                                {{-- LEFT SIDE: Task Info --}}
                                <div class="flex-1 mb-4 sm:mb-0">
                                    {{-- Title --}}
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                        {{ $task->title }}
                                    </h4>
                                    
                                    {{-- Link --}}
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 text-xs font-semibold underline mb-2 inline-block">
                                        View Comments / Feedback
                                    </a>

                                    {{-- Badges Row --}}
                                    <div class="flex items-center gap-2 mt-1">
                                        {{-- Static Status Badge (Visual only) --}}
                                        <span class="px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-full 
                                            {{ $task->status == 'Done' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                              ($task->status == 'In Progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                              'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                            {{ $task->status }}
                                        </span>

                                        {{-- Due Date Badge --}}
                                        <span class="px-3 py-1 text-[10px] font-bold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md">
                                            Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- RIGHT SIDE: Actions --}}
                                <div class="flex items-center gap-4">
                                    
                                    {{-- Status Update Dropdown --}}
                                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                        @csrf 
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-sm font-semibold rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500 cursor-pointer py-2 pl-3 pr-8 shadow-sm">
                                            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </form>

                                    {{-- Delete Button (Trash Icon) --}}
                                    <form method="POST" action="{{ route('admin.task.delete', $task->id) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors rounded-full hover:bg-red-50 dark:hover:bg-red-900/30">
                                            {{-- SVG Trash Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>