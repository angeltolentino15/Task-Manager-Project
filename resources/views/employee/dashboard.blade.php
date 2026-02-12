<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-900 p-6 shadow-xl rounded-xl mb-6 border-2 border-gray-400 dark:border-gray-700">
                <form action="{{ route('employee.tasks.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="file" name="attachment" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <button type="submit" ...>Add</button>
                    
                    <input 
                        type="text" 
                        name="title" 
                        placeholder="New Task..." 
                        class="w-full rounded-lg border-gray-400 dark:border-gray-600 dark:bg-black dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-inner"
                        required
                    >

                    <input 
                        type="date" 
                        name="due_date" 
                        class="rounded-lg border-gray-400 dark:border-gray-600 dark:bg-black dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-inner"
                    >

                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg font-bold shadow-lg transition transform active:scale-95"
                    >
                        Add
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-900 p-6 shadow-xl rounded-xl mb-6 border-2 border-gray-400 dark:border-gray-700">
                @if($tasks->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center py-6 italic">No tasks found. Add your first task above!</p>
                @else
                    @foreach($tasks as $task)
                        <div class="flex justify-between items-center border-b border-gray-300 dark:border-gray-800 py-5 last:border-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition px-3 -mx-3 rounded-lg">
                            
                            <div class="flex-1">
                                <h4 class="font-extrabold text-lg {{ $task->status == 'Done' ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $task->title }}
                                </h4>
                                
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-200 text-xs font-bold underline">
                                    View Comments / Feedback
                                </a>

                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-wider rounded-full shadow-sm
                                        {{ $task->status == 'Done' ? 'bg-green-200 text-green-900 dark:bg-green-900/60 dark:text-green-300' : 
                                          ($task->status == 'In Progress' ? 'bg-blue-200 text-blue-900 dark:bg-blue-900/60 dark:text-blue-300' : 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                        {{ $task->status }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-950 px-2 py-0.5 rounded border border-gray-200 dark:border-gray-800">
                                        Due: {{ $task->due_date ?? 'No Date' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                        class="text-sm font-bold border-gray-400 dark:border-gray-600 dark:bg-black dark:text-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                                        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-transform active:scale-90">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>