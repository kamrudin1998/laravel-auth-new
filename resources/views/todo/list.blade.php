@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-900 text-white px-6 sm:px-10 py-10">

    <!-- Floating Add Button -->
    <a href="{{ route('todo.create') }}"
       class="fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-full shadow-2xl flex items-center justify-center z-50 text-white text-2xl transition transform hover:scale-110">
        <i class="fas fa-plus"></i>
    </a>

    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl sm:text-5xl font-bold mb-2">
            <i class="fas fa-list mr-3 text-blue-400"></i>My Tasks
        </h1>
        <p class="text-gray-400">Track and manage all your tasks efficiently</p>
    </div>

    {{-- ================= SEARCH & SORT ================= --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-10">
        <div class="md:col-span-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="w-full px-4 py-3 rounded-lg bg-slate-800 text-white placeholder-gray-500 border border-slate-700 focus:outline-none focus:border-blue-500 transition"
                   placeholder="Search tasks…">
        </div>

        <select name="sort" class="px-4 py-3 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:border-blue-500 transition">
            <option value="">Sort By...</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due Date</option>
            <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
        </select>

        <div class="flex gap-2">
            <button class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold transition flex items-center justify-center gap-2">
                <i class="fas fa-search"></i> <span class="hidden sm:inline">Search</span>
            </button>

            <a href="{{ route('todo.index') }}" class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold transition text-center flex items-center justify-center gap-2">
                <i class="fas fa-redo"></i> <span class="hidden sm:inline">Reset</span>
            </a>
        </div>
    </form>

    {{-- ================= OVERDUE SECTION ================= --}}
    @if($overdueTodos->count())
        <div class="mb-10">
            <h2 class="text-xl font-bold text-red-400 mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>Overdue Tasks ({{ $overdueTodos->count() }})
            </h2>

            @foreach($overdueTodos as $todo)
                <div class="bg-red-900 bg-opacity-20 border-l-4 border-red-500 rounded-lg p-5 mb-4 hover:bg-opacity-30 transition">
                    <div class="flex justify-between items-start gap-4 flex-wrap">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-red-300">{{ $todo->title }}</h3>
                            @if($todo->description)
                                <p class="text-red-200 text-sm mt-1">{{ Str::limit($todo->description, 100) }}</p>
                            @endif
                            <div class="flex gap-3 mt-2 flex-wrap text-sm">
                                <span class="text-red-300 flex items-center gap-1">
                                    <i class="fas fa-calendar"></i> Due {{ $todo->due_date }}
                                </span>
                                <span class="px-2 py-1 bg-red-600 rounded text-white text-xs font-semibold">
                                    {{ ucfirst($todo->progress) }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('todo.show', $todo->id) }}"
                           class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white text-sm font-semibold transition whitespace-nowrap">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ================= TASK LIST ================= --}}
    @if($todos->count())
        <div>
            <h2 class="text-xl font-bold text-blue-300 mb-4 flex items-center">
                <i class="fas fa-tasks mr-2"></i>Active Tasks ({{ $todos->count() }})
            </h2>

            <div class="space-y-4">
                @foreach($todos as $todo)
                <div class="bg-slate-800 rounded-lg border border-slate-700 hover:border-blue-500 p-6 transition shadow-md hover:shadow-lg">
                    <div class="flex justify-between items-start gap-4 flex-wrap sm:flex-nowrap">

                        <!-- Task Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-3 flex-wrap">
                                <h3 class="text-lg font-bold text-white break-words">{{ $todo->title }}</h3>
                                
                                {{-- Priority Badge --}}
                                @if($todo->priority == 'high')
                                    <span class="px-3 py-1 bg-red-600 text-white rounded-full text-xs font-bold flex items-center gap-1">
                                        <i class="fas fa-arrow-up"></i> High
                                    </span>
                                @elseif($todo->priority == 'medium')
                                    <span class="px-3 py-1 bg-yellow-600 text-white rounded-full text-xs font-bold flex items-center gap-1">
                                        <i class="fas fa-minus"></i> Medium
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-600 text-white rounded-full text-xs font-bold flex items-center gap-1">
                                        <i class="fas fa-arrow-down"></i> Low
                                    </span>
                                @endif
                            </div>

                            @if($todo->description)
                                <p class="text-gray-300 text-sm mb-4">{{ Str::limit($todo->description, 120) }}</p>
                            @endif

                            {{-- Info Row --}}
                            <div class="flex gap-4 text-sm text-gray-400 mb-4 flex-wrap">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-calendar text-blue-400"></i> {{ $todo->due_date ?? 'No due date' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-spinner text-purple-400"></i> {{ ucfirst($todo->progress) }}
                                </span>
                            </div>

                            {{-- Progress Bar --}}
                            @php
                                $percent = match($todo->progress) {
                                    'pending' => 0,
                                    'inprogress' => 50,
                                    'completed' => 100,
                                    default => 0,
                                };
                            @endphp

                            <div class="mt-3">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs text-gray-400">Progress</span>
                                    <span class="text-xs font-bold text-blue-400">{{ $percent }}%</span>
                                </div>
                                <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-300
                                        @if($todo->progress == 'completed') bg-gradient-to-r from-green-500 to-green-400
                                        @elseif($todo->progress == 'inprogress') bg-gradient-to-r from-yellow-500 to-yellow-400
                                        @else bg-gradient-to-r from-gray-500 to-gray-400 @endif"
                                        style="width: {{ $percent }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 items-center flex-wrap sm:flex-nowrap lg:flex-col">
                            <a href="{{ route('todo.show', $todo->id) }}"
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1">
                                <i class="fas fa-eye"></i> <span class="hidden lg:inline">View</span>
                            </a>

                            @if($todo->user_id == auth()->id())
                                <a href="{{ route('todo.edit', $todo->id) }}"
                                   class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1">
                                    <i class="fas fa-edit"></i> <span class="hidden lg:inline">Edit</span>
                                </a>

                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1"
                                            onclick="return confirm('Delete this task?')">
                                        <i class="fas fa-trash"></i> <span class="hidden lg:inline">Delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10 flex justify-center">
                {{ $todos->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl text-gray-600 mb-4">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-300 mb-2">No Tasks Found</h3>
            <p class="text-gray-400 mb-6">Create your first task to get started!</p>
            <a href="{{ route('todo.create') }}" class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white font-semibold transition">
                <i class="fas fa-plus mr-2"></i> Create Task
            </a>
        </div>
    @endif

</div>
@endsection
