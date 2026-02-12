<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-2 border-gray-300 dark:border-gray-700 shadow-md">
                    <p class="text-sm font-black text-gray-500 uppercase">Total Employees</p>
                    <p class="text-3xl font-black text-blue-600">{{ $totalEmployees }} Users</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-2 border-gray-300 dark:border-gray-700 shadow-md">
                    <p class="text-sm font-black text-gray-500 uppercase">Pending Tasks</p>
                    <p class="text-3xl font-black text-yellow-500">{{ $pendingTasks }} Waiting</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-2 border-gray-300 dark:border-gray-700 shadow-md">
                    <p class="text-sm font-black text-gray-500 uppercase">Completed</p>
                    <p class="text-3xl font-black text-green-600">{{ $completedTasks }} Done</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-2 border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-200">Employee List</h3>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($employees as $emp)
                        <li class="py-4 flex justify-between items-center">
                            <span class="text-gray-700 dark:text-gray-300">
                                <strong>{{ $emp->name }}</strong> 
                                <span class="text-sm text-gray-500">({{ $emp->email }})</span>
                            </span>
                            <a href="{{ route('admin.employee.tasks', $emp->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                View Tasks
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>