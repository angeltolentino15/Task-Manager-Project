{{-- Main application layout wrapper --}}
<x-app-layout>
    {{-- Header slot with page title --}}
    <x-slot name="header">
        {{-- Dashboard page title --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Main content area with vertical padding --}}
    <div class="py-12">
        {{-- Centered container with max width and responsive padding --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Content card with shadow and rounded corners --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Card content with padding --}}
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Welcome message for logged-in users --}}
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>