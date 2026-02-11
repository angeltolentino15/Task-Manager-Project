<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">My Tasks</h2></x-slot>

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
                    <div>
                        <h4 class="font-bold">{{ $task->title }}</h4>
                        <p class="text-sm text-gray-500">Status: {{ $task->status }}</p>
                    </div>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-500">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div></div>
</x-app-layout>