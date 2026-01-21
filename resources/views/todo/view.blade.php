@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-4 sm:px-6 py-8 sm:py-12">

    <div class="max-w-3xl mx-auto">

        <!-- Breadcrumb -->
        <a href="{{ route('todo.index') }}"
           class="text-blue-400 hover:text-blue-300 mb-8 inline-flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> <span class="text-sm">Back to Tasks</span>
        </a>

        <!-- Task Card -->
        <div class="bg-slate-800 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-700 hover:border-slate-600 transition">

            <!-- Title & Status -->
            <div class="mb-8 pb-6 border-b border-slate-700">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-white break-words">{{ $todo->title }}</h1>

                <div class="flex gap-3 flex-wrap items-center">

                    <!-- Priority Badge -->
                    @if($todo->priority == 'high')
                        <span class="px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-full text-xs sm:text-sm font-bold text-white inline-flex items-center gap-1 transition">
                            <i class="fas fa-arrow-up"></i> <span>High Priority</span>
                        </span>
                    @elseif($todo->priority == 'medium')
                        <span class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 rounded-full text-xs sm:text-sm font-bold text-white inline-flex items-center gap-1 transition">
                            <i class="fas fa-minus"></i> <span>Medium Priority</span>
                        </span>
                    @else
                        <span class="px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-full text-xs sm:text-sm font-bold text-white inline-flex items-center gap-1 transition">
                            <i class="fas fa-arrow-down"></i> <span>Low Priority</span>
                        </span>
                    @endif

                    <!-- Progress Badge -->
                    <span class="px-3 py-1.5 bg-blue-600 rounded-full text-xs sm:text-sm font-bold text-white inline-flex items-center gap-1">
                        <i class="fas fa-spinner"></i> {{ ucfirst($todo->progress) }}
                    </span>

                </div>
            </div>

            <!-- Description -->
            @if($todo->description)
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-bold text-blue-300 mb-3 inline-flex items-center gap-2">
                        <i class="fas fa-align-left"></i> <span>Description</span>
                    </h3>
                    <p class="text-gray-300 leading-relaxed text-sm sm:text-base">{{ $todo->description }}</p>
                </div>
            @endif

            <!-- Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 pb-8 border-b border-slate-700">
                <div class="bg-slate-900 rounded-lg p-4 border border-slate-700">
                    <h4 class="text-xs sm:text-sm text-gray-400 font-semibold mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-400"></i> Due Date
                    </h4>
                    <p class="text-sm sm:text-base text-white font-medium">{{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') : 'Not set' }}</p>
                </div>

                <div class="bg-slate-900 rounded-lg p-4 border border-slate-700">
                    <h4 class="text-xs sm:text-sm text-gray-400 font-semibold mb-2 flex items-center gap-2">
                        <i class="fas fa-clock text-green-400"></i> Created
                    </h4>
                    <p class="text-sm sm:text-base text-white font-medium">{{ $todo->created_at->format('M d, Y') }}</p>
                </div>

                <div class="bg-slate-900 rounded-lg p-4 border border-slate-700">
                    <h4 class="text-xs sm:text-sm text-gray-400 font-semibold mb-2 flex items-center gap-2">
                        <i class="fas fa-user text-purple-400"></i> Owner
                    </h4>
                    <p class="text-sm sm:text-base text-white font-medium">{{ $todo->user->name }}</p>
                </div>
            </div>

            <!-- Progress Bar -->
            @php
                $percent = match($todo->progress) {
                    'pending' => 0,
                    'inprogress' => 50,
                    'completed' => 100,
                    default => 0,
                };
            @endphp

            <div class="mb-10 bg-slate-900 rounded-lg p-5 border border-slate-700">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm sm:text-base font-semibold text-gray-300 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-blue-400"></i> Completion Progress
                    </span>
                    <span class="text-lg sm:text-xl font-bold text-blue-400">{{ $percent }}%</span>
                </div>

                <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full transition-all duration-300 ease-out
                        @if($percent == 100) bg-gradient-to-r from-green-500 to-green-400
                        @elseif($percent == 50) bg-gradient-to-r from-yellow-500 to-yellow-400
                        @else bg-gradient-to-r from-gray-500 to-gray-400 @endif"
                        style="width: {{ $percent }}%">
                    </div>
                </div>
            </div>
            {{-- ================= COMMENTS SECTION ================= --}}
            <div class="mt-10 border-t border-slate-700 pt-8">

                <h3 class="text-lg sm:text-xl font-bold text-blue-300 mb-6 inline-flex items-center gap-2">
                    <i class="fas fa-comments"></i> <span>Comments</span> <span class="text-sm bg-blue-600 text-white px-2 py-1 rounded-full">{{ $todo->comments->count() }}</span>
                </h3>

                @forelse($todo->comments as $comment)
                    <div class="bg-slate-900 border border-slate-700 rounded-lg p-4 sm:p-5 mb-4 hover:border-slate-600 transition shadow-sm">
                        <div class="flex justify-between items-start gap-3 mb-3">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <img src="{{ asset('storage/' . $comment->user->profile_photo) ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                     class="w-8 h-8 rounded-full border border-blue-400 flex-shrink-0"
                                     style="object-fit: cover;">
                                <span class="font-semibold text-white text-sm sm:text-base">{{ $comment->user->name }}</span>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-gray-300 leading-relaxed text-sm sm:text-base break-words">
                            {{ $comment->comment }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-8 bg-slate-900 rounded-lg border border-slate-700">
                        <i class="fas fa-comment-slash text-gray-600 text-3xl mb-3"></i>
                        <p class="text-gray-500 text-sm">No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse
            </div>

            {{-- ================= ADD COMMENT FORM ================= --}}
            @if($todo->status === 'public')
                <div class="mt-8 bg-slate-900 rounded-lg p-5 border border-slate-700">
                    <h4 class="text-base sm:text-lg font-bold text-blue-300 mb-4 flex items-center gap-2">
                        <i class="fas fa-pen-to-square"></i> <span>Add Your Comment</span>
                    </h4>
                    <form action="{{ route('todo.comment', $todo->id) }}" method="POST">
                        @csrf

                        <textarea
                            name="comment"
                            rows="4"
                            required
                            class="w-full px-4 py-3 rounded-lg bg-slate-800 text-white border border-slate-700 placeholder-gray-500
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition text-sm sm:text-base"
                            placeholder="Share your thoughts..."></textarea>

                        @error('comment')
                            <div class="mt-2 p-3 bg-red-900 border border-red-700 rounded-lg">
                                <span class="text-red-200 text-sm">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition inline-flex items-center gap-2 text-sm sm:text-base">
                                <i class="fas fa-paper-plane"></i> Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-8 bg-yellow-900 bg-opacity-20 border border-yellow-700 rounded-lg p-5">
                    <p class="text-yellow-300 text-sm sm:text-base inline-flex items-center gap-2">
                        <i class="fas fa-lock"></i> This task is private. Only the owner can see and comment.
                    </p>
                </div>
            @endif

            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="mt-10 pt-8 border-t border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">

                <!-- Back Button -->
                <a href="{{ route('todo.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5
                          bg-slate-700 hover:bg-slate-600 active:scale-95
                          rounded-lg text-sm font-medium transition transform">
                    <i class="fas fa-arrow-left"></i> <span>Back to Tasks</span>
                </a>

                <!-- Edit / Delete Buttons -->
                @if($todo->user_id == auth()->id())
                    <div class="w-full sm:w-auto flex items-center gap-3 flex-wrap justify-end sm:justify-start">
                        <a href="{{ route('todo.edit', $todo->id) }}"
                           class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5
                                  bg-purple-600 hover:bg-purple-700 active:scale-95
                                  rounded-lg text-sm font-medium transition transform">
                            <i class="fas fa-edit"></i> <span>Edit</span>
                        </a>

                        <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this task? This action cannot be undone.')"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5
                                       bg-red-600 hover:bg-red-700 active:scale-95
                                       rounded-lg text-sm font-medium transition transform">
                                <i class="fas fa-trash"></i> <span>Delete</span>
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
@endsection
