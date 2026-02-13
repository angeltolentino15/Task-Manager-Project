<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200 dark:bg-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.employee.tasks', $task->user_id) }}" class="inline-flex items-center text-gray-700 hover:text-black dark:text-gray-400 dark:hover:text-white font-bold transition uppercase tracking-wider text-sm">
                        <span class="mr-2">&larr;</span> Back to Tasks for: <span class="ml-1 font-black text-blue-600 dark:text-blue-400">{{ $task->user->name }}</span>
                    </a>
                @else
                    <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-black dark:text-gray-400 dark:hover:text-white font-bold transition uppercase tracking-wider text-sm">
                        <span class="mr-2">&larr;</span> Back to My Tasks
                    </a>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-900 p-8 shadow-xl rounded-xl border-2 border-gray-300 dark:border-gray-700 mb-8">
                
                <div class="flex justify-between items-start border-b border-gray-200 dark:border-gray-800 pb-6 mb-6">
                    <div>
                        <h2 class="font-black text-3xl text-gray-900 dark:text-white leading-tight tracking-tight mb-2">
                            {{ $task->title }}
                        </h2>
                        <div class="flex items-center gap-4 text-sm font-bold text-gray-500">
                            <span>Assigned to: <span class="text-gray-800 dark:text-gray-300">{{ $task->user->name }}</span></span>
                            <span>•</span>
                            <span>Due: <span class="text-gray-800 dark:text-gray-300">{{ $task->due_date ?? 'No Date Set' }}</span></span>
                        </div>
                    </div>

                    <span class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-lg shadow-sm border-2
                        {{ $task->status == 'Done' ? 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900/40 dark:text-green-300 dark:border-green-700' : 
                          ($task->status == 'In Progress' ? 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-700' : 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-900/40 dark:text-yellow-300 dark:border-yellow-700') }}">
                        {{ $task->status }}
                    </span>
                </div>

                <div>
                    <h3 class="text-xs font-black uppercase text-gray-500 mb-3 tracking-widest">Task Instructions & Details</h3>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 leading-relaxed font-medium whitespace-pre-line">
                        {{ $task->description ?? 'No extra details were provided for this task.' }}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 p-8 shadow-xl rounded-xl border-2 border-gray-300 dark:border-gray-700">
                <h3 class="font-black text-xl text-gray-900 dark:text-white uppercase tracking-tight mb-6 pb-4 border-b border-gray-200 dark:border-gray-800">
                    Feedback & Comments
                </h3>

                <div class="space-y-6 mb-8">
                    @foreach($task->comments as $comment)
                        <div class="flex {{ $comment->user->role === 'admin' ? 'justify-end' : 'justify-start' }}">
                            
                            <div class="rounded-xl px-5 py-3 max-w-lg shadow-sm border-2 
                                {{ $comment->user->role === 'admin' ? 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800 text-right rounded-tr-none' : 'bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700 text-left rounded-tl-none' }}">
                                
                                <p class="text-xs font-black tracking-wider uppercase mb-1 
                                    {{ $comment->user->role === 'admin' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $comment->user->name }} ({{ ucfirst($comment->user->role) }})
                                </p>
                                
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $comment->body }}</p>
                                
                                <p class="text-[10px] font-bold mt-2 text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($task->comments->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wider text-sm">No comments yet. Be the first to post an update!</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('comments.store', $task->id) }}" method="POST" class="border-t border-gray-200 dark:border-gray-800 pt-6">
                    @csrf
                    <div class="flex flex-col space-y-3">
                        <label class="text-xs font-black uppercase text-gray-500">Add an update or ask a question</label>
                        <textarea name="body" rows="3" placeholder="Type your message here..." class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-black dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 p-3" required></textarea>
                        
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest py-3 px-8 rounded-lg shadow-lg transition-all transform active:scale-95 text-xs">
                                Post Comment
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>