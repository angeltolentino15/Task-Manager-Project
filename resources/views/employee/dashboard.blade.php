<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">My Tasks</h2></x-slot>

    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm rounded-lg mb-6">
            <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="title" placeholder="New Task..." class="border rounded p-2 w-full" required>
                <input type="date" name="due_date" class="border rounded p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
            </form>
        </div>

        <div class="bg-white p-6 shadow-sm rounded-lg">
    @foreach($tasks as $task)
        <div class="flex justify-between items-center border-b py-3">
            
            <div class="flex-1">
                <h4 class="font-bold text-lg {{ $task->status == 'Done' ? 'line-through text-gray-400' : 'text-gray-800' }}">
                    {{ $task->title }}
                </h4>
                <a href="{{ route('tasks.show', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs underline">
                    View Comments / Feedback
                </a>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $task->status == 'Done' ? 'bg-green-100 text-green-800' : 
                          ($task->status == 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $task->status }}
                    </span>
                    <span class="text-xs text-gray-500">Due: {{ $task->due_date ?? 'No Date' }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    
                    <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cursor-pointer">
                        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                    </select>
                </form>

                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    @endforeach
</div>
    </div></div>
</x-app-layout>