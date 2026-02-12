<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            Task Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.employee.tasks', $task->user_id) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        &larr; Back to Tasks for: <span class="font-bold">{{ $task->user->name }}</span>
                    </a>
                @else
                    <a href="{{ route('employee.dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        &larr; Back to My Tasks
                    </a>
                @endif
            </div>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $task->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Assigned to: {{ $task->user->name }}</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-bold rounded-full 
                        {{ $task->status == 'Done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $task->status }}
                    </span>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <p class="text-gray-700">{{ $task->description ?? 'No description provided.' }}</p>
                    <p class="mt-4 text-sm text-gray-500">Due Date: {{ $task->due_date ?? 'None' }}</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Feedback & Comments</h3>

                <div class="space-y-4 mb-6">
                    @foreach($task->comments as $comment)
                        <div class="flex {{ $comment->user->role === 'admin' ? 'justify-end' : 'justify-start' }}">
                            <div class="rounded-lg px-4 py-2 max-w-lg 
                                {{ $comment->user->role === 'admin' ? 'bg-blue-100 text-blue-900 text-right' : 'bg-gray-100 text-gray-900' }}">
                                <p class="text-sm font-bold text-xs mb-1">{{ $comment->user->name }} ({{ ucfirst($comment->user->role) }})</p>
                                <p>{{ $comment->body }}</p>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($task->comments->isEmpty())
                        <p class="text-gray-400 text-center text-sm">No comments yet.</p>
                    @endif
                </div>

                <form action="{{ route('comments.store', $task->id) }}" method="POST" class="mt-4">
                    @csrf
                    <textarea name="body" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Type your comment here..." required></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Post Comment</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>