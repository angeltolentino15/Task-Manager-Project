{{-- Main application layout wrapper --}}
<x-app-layout>
    {{-- Header slot with page title --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    {{-- Main content area with background and minimum height --}}
    <div class="py-12 bg-gray-200 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Statistics Cards Grid - 4 column responsive layout --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                
                {{-- Total Employees Card - Blue themed --}}
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-4 border-l-4 border-blue-500 flex flex-col justify-center min-w-[200px]">
                    <p class="text-sm font-black text-gray-500 uppercase tracking-wide">Total Employees</p>
                    <p class="text-3xl font-black text-blue-600">{{ $totalEmployees }} Users</p>
                </div>
                
                {{-- Pending Tasks Card - Red themed --}}
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-4 border-l-4 border-red-500 flex flex-col justify-center min-w-[200px]">
                    <p class="text-sm font-black text-gray-500 uppercase tracking-wide">Total Pending Tasks</p>
                    <p class="text-3xl font-black text-red-500">{{ $pendingTasks }} Waiting</p>
                </div>

                {{-- In Progress Tasks Card - Yellow themed --}}
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-4 border-l-4 border-yellow-500 flex flex-col justify-center min-w-[200px]">
                    <p class="text-sm font-black text-gray-500 uppercase tracking-wide">In Progress</p>
                    <p class="text-3xl font-black text-yellow-500">{{ $InProgress }} Active</p>
                </div>                

                {{-- Completed Tasks Card - Green themed --}}
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-4 border-l-4 border-green-500 flex flex-col justify-center min-w-[200px]">
                    <p class="text-sm font-black text-gray-500 uppercase tracking-wide">Completed</p>
                    <p class="text-3xl font-black text-green-500">{{ $completedTasks }} Done</p>
                </div>
            </div>

            {{-- Action Button Section - Create New User --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.employee.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest py-3 px-6 rounded-lg shadow-lg transition-all transform active:scale-95 text-sm">
                    + Create New User
                </a>
            </div>

            {{-- Employee List Section - Main content card --}}
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl rounded-xl p-8 border-2 border-gray-300 dark:border-gray-700">
                
                {{-- Section Header with Title and Assign Task Button --}}
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Employee List</h3>
                    
                    {{-- Assign Task Button --}}
                    <a href="{{ route('admin.tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition uppercase text-sm tracking-wider">
                        + Assign Task
                    </a>
                </div>

                {{-- Employee List - Divided list with hover effects --}}
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    {{-- Loop through each employee --}}
                    @foreach($employees as $emp)
                        <li class="py-5 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800/50 px-3 -mx-3 rounded-lg transition">
                            
                            {{-- Employee Information Section --}}
                            <span class="text-gray-900 dark:text-gray-200">
                                {{-- Employee Name --}}
                                <strong class="text-lg font-extrabold">{{ $emp->name }}</strong> 
                                
                                {{-- Employee Email and ID --}}
                                <span class="text-sm text-gray-500 ml-2 font-medium">
                                    ({{ $emp->email }}) 
                                    {{-- Employee ID Badge --}}
                                    <span class="ml-2 px-2 py-0.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded text-xs uppercase tracking-wider">
                                        {{ $emp->employee_id ?? 'No ID' }}
                                    </span>
                                </span>
                            </span>
                            
                            {{-- Action Buttons Section --}}
                            <div class="flex items-center space-x-6">
                                {{-- View Tasks Link --}}
                                <a href="{{ route('admin.employee.tasks', $emp->id) }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline tracking-wide">
                                    View Tasks
                                </a>

                                {{-- Delete Employee Form with Confirmation --}}
                                <form action="{{ route('admin.employee.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-bold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:underline tracking-wide">
                                        Delete Account
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Empty State Message - Shown when no employees exist --}}
                @if($employees->isEmpty())
                    <p class="text-center text-gray-500 py-8 italic font-medium">No employees found in the system.</p>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>