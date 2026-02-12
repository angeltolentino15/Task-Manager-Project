<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task App Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col justify-center items-center">
    
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Welcome to Task Manager</h1>
        <p class="text-gray-500 mt-2">Please select your portal</p>
    </div>

    @auth
        <div class="flex flex-col items-center p-6">
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Logging you out...</h2>
            <p class="text-sm text-gray-500">Please wait a moment.</p>

            <form id="auto-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>

        <script>
            window.addEventListener('pageshow', function(event) {
                // This forces the logout form to submit every time this page becomes visible
                document.getElementById('auto-logout-form').submit();
            });
        </script>
    @else
        <div class="flex space-x-8">
            <a href="{{ route('login', ['type' => 'admin']) }}" class="group flex flex-col items-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all cursor-pointer border border-transparent hover:border-blue-500 w-48">
                <div class="text-blue-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-xl font-semibold text-gray-700 dark:text-gray-200 group-hover:text-blue-500">Admin</span>
                <span class="text-xs text-gray-400 mt-2">Login Only</span>
            </a>

            <a href="{{ route('login', ['type' => 'employee']) }}" class="group flex flex-col items-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all cursor-pointer border border-transparent hover:border-green-500 w-48">
                <div class="text-green-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 5.472m0 0a9.09 9.09 0 00-3.279 3.298m.098-4.67c0-2.388 1.933-4.313 4.314-4.313S12.087 8.587 12.087 10.976m0 0c0-2.388 1.933-4.313 4.314-4.313S20.715 8.587 20.715 10.976" />
                    </svg>
                </div>
                <span class="text-xl font-semibold text-gray-700 dark:text-gray-200 group-hover:text-green-500">Employee</span>
                <span class="text-xs text-gray-400 mt-2">Login or Register</span>
            </a>
        </div>
    @endauth
</body>
</html>