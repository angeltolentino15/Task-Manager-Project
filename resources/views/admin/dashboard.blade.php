<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2></x-slot>

    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">Employee List</h3>
            <ul>
                @foreach($employees as $emp)
                    <li class="border-b py-4 flex justify-between">
                        <span>{{ $emp->name }} ({{ $emp->email }})</span>
                        <a href="{{ route('admin.employee.tasks', $emp->id) }}" class="text-blue-500 hover:underline">View Tasks</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div></div>
</x-app-layout>