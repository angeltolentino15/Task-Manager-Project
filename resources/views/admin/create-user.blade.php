{{-- Main application layout wrapper --}}
<x-app-layout>
    <div class="py-12">
        {{-- Container with responsive max-width and padding --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Back navigation link --}}
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="mb-4 text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center transition">
                    <span class="mr-2">&larr;</span> Back to Admin Dashboard
                </a>
            </div>            
            
            {{-- Main form card with dark mode support --}}
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
            
                {{-- Page heading --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight mb-6">Add New User</h2>

                {{-- Validation errors display section --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm">
                            {{-- Loop through all validation errors --}}
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- User creation form --}}
                <form action="{{ route('admin.employee.store') }}" method="POST">
                    {{-- CSRF token for security --}}
                    @csrf
                    
                    {{-- Form fields container with gap spacing --}}
                    <div class="flex flex-col gap-6">
                        
                        {{-- Name input field --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        </div>

                        {{-- Email input field --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        </div>

                        {{-- Department input field --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Department</label>
                            <input type="text" name="department" value="{{ old('department') }}" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        </div>

                        {{-- Position input field --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        </div>

                        {{-- Phone number input field --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        </div>
                        
                        {{-- Password field with toggle visibility (Alpine.js) --}}
                        <div x-data="{ show: false }">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Password</label>
                            <div class="relative">
                                {{-- Password input that toggles between text/password type --}}
                                <input :type="show ? 'text' : 'password'" name="password" 
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm pr-10" required>
                                
                                {{-- Toggle button for showing/hiding password --}}
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                                    
                                    {{-- Eye icon - shown when password is hidden --}}
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    
                                    {{-- Eye-slash icon - shown when password is visible --}}
                                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Password confirmation field with toggle visibility (Alpine.js) --}}
                        <div x-data="{ show: false }">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-400 mb-2">Confirm Password</label>
                            <div class="relative">
                                {{-- Password confirmation input that toggles between text/password type --}}
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" 
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm pr-10" required>
                                
                                {{-- Toggle button for showing/hiding password confirmation --}}
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                                    
                                    {{-- Eye icon - shown when password is hidden --}}
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    
                                    {{-- Eye-slash icon - shown when password is visible --}}
                                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>

                    {{-- Form submit button section --}}
                    <div class="mt-8">
                        <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                            Save User Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>