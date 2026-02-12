<x-app-layout>
    <div class="py-12 bg-gray-200 dark:bg-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-black dark:text-gray-400 dark:hover:text-white font-bold transition">
                    <span class="mr-2">&larr;</span> Back to Admin Dashboard
                </a>
            </div>            

            <div class="bg-white dark:bg-gray-900 p-8 shadow-xl rounded-xl border-2 border-gray-300 dark:border-gray-700">
                
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight mb-6 uppercase tracking-tight">
                    Assign New Task
                </h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        <p class="font-black mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm font-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col space-y-5">
                        
                        <div class="space-y-1">
                            <label class="text-xs font-black uppercase text-gray-500 ml-1">Assign To Employee</label>
                            <select name="user_id" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-black dark:text-gray-300 focus:border-violet-500 focus:ring-violet-500 h-12 cursor-pointer font-bold" required>
                                <option value="" disabled selected>Select an employee...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }} ({{ $employee->employee_id ?? 'No ID' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-black uppercase text-gray-500 ml-1">Task Title / Description</label>
                            <input type="text" name="title" placeholder="What needs to be done?" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-black dark:text-gray-300 focus:border-violet-500 focus:ring-violet-500 h-12" required>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-black uppercase text-gray-500 ml-1">Due Date</label>
                            <input type="date" name="due_date" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-black dark:text-gray-300 focus:border-violet-500 focus:ring-violet-500 h-12">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest py-4 rounded-lg shadow-lg transition-all transform active:scale-95 text-sm">
                                Assign Task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>