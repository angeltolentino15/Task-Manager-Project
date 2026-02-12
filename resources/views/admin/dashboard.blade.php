<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Admin Dashboard') }}
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
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Employee List</h3>
                    <a href="{{ route('admin.employee.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        + Create New User
                    </a>
                </div>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($employees as $emp)
                        <li class="py-4 flex justify-between items-center">
                            <span class="text-gray-700 dark:text-gray-300">
                                <strong class="text-base">{{ $emp->name }}</strong> 
                                <span class="text-sm text-gray-500 ml-2">({{ $emp->email }})</span>
                            </span>
                            
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.employee.tasks', $emp->id) }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                    View Tasks
                                </a>

                                <form action="{{ route('admin.employee.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 dark:text-red-400 hover:underline">
                                        Delete Account
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if($employees->isEmpty())
                    <p class="text-center text-gray-500 py-4">No employees found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>