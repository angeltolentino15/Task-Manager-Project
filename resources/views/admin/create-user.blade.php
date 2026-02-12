<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="mb-6">
                                <a href="{{ route('admin.dashboard') }}" class="mb-4 text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white flex items-center transition">
                                    <span class="mr-2">&larr;</span> Back to Admin Dashboard
                                </a>
                            </div>            
            <div class="bg-white p-6 shadow-sm rounded-lg">
            
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Add New User</h2>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.employee.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" class="border-gray-300 rounded-md shadow-sm" required>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="border-gray-300 rounded-md shadow-sm" required>
                        <input type="text" name="department" value="{{ old('department') }}" placeholder="Department" class="border-gray-300 rounded-md shadow-sm" required>
                        <input type="text" name="position" value="{{ old('position') }}" placeholder="Position" class="border-gray-300 rounded-md shadow-sm" required>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" class="border-gray-300 rounded-md shadow-sm" required>
                        
                        <div class="md:col-start-1">
                            <input type="password" name="password" placeholder="Password" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white dark:text-gray-500 px-4 py-2 rounded shadow transition">
                        Save User Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>