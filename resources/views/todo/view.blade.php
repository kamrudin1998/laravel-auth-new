@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-6 py-10">

    <div class="max-w-2xl mx-auto">

        <!-- Breadcrumb -->
        <a href="{{ route('todo.index') }}" class="text-blue-400 hover:text-blue-300 mb-6 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Tasks
        </a>

        <!-- Task Card -->
        <div class="bg-slate-800 rounded-lg shadow-2xl p-8 border border-slate-700">
            
            <!-- Title & Status -->
            <div class="mb-8 pb-6 border-b border-slate-700">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-3">{{ $todo->title }}</h1>
                        
                        <div class="flex gap-3 flex-wrap">
                            <!-- Priority -->
                            <span class="px-4 py-2 rounded-lg text-white text-sm font-bold flex items-center gap-2 {{ $todo->priority == 'high' ? 'bg-red-600' : ($todo->priority == 'medium' ? 'bg-yellow-600' : 'bg-green-600') }}">
                                @if($todo->priority == 'high')
                                    <i class="fas fa-arrow-up"></i> High Priority
                                @elseif($todo->priority == 'medium')
                                    <i class="fas fa-minus"></i> Medium Priority
                                @else
                                    <i class="fas fa-arrow-down"></i> Low Priority
                                @endif
                            </span>

                            <!-- Status -->
                            @if($todo->due_date && $todo->due_date < now()->toDateString())
                                <span class="px-4 py-2 bg-red-900 text-red-200 rounded-lg text-sm font-bold flex items-center gap-2 border border-red-700">
                                    <i class="fas fa-exclamation-triangle"></i> Overdue
                                </span>
                            @else
                                <span class="px-4 py-2 bg-blue-900 text-blue-200 rounded-lg text-sm font-bold flex items-center gap-2 border border-blue-700">
                                    @if($todo->progress == 'completed')
                                        <i class="fas fa-check-circle"></i> Completed
                                    @elseif($todo->progress == 'inprogress')
                                        <i class="fas fa-spinner"></i> In Progress
                                    @else
                                        <i class="fas fa-clock"></i> Pending
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($todo->description)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-blue-300 mb-3">
                        <i class="fas fa-align-left mr-2"></i> Description
                    </h3>
                    <p class="text-gray-300 leading-relaxed text-base">{{ $todo->description }}</p>
                </div>
            @endif

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b border-slate-700">
                <!-- Due Date -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Due Date</h4>
                    <p class="text-lg text-white flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-400"></i>
                        {{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') : 'Not set' }}
                    </p>
                </div>

                <!-- Progress -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Progress</h4>
                    <p class="text-lg text-white flex items-center gap-2">
                        <i class="fas fa-spinner text-purple-400"></i>
                        {{ ucfirst($todo->progress) }}
                    </p>
                </div>

                <!-- Created -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Created</h4>
                    <p class="text-lg text-white flex items-center gap-2">
                        <i class="fas fa-plus-circle text-green-400"></i>
                        {{ $todo->created_at->format('M d, Y H:i') }}
                    </p>
                </div>

                <!-- Updated -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Last Updated</h4>
                    <p class="text-lg text-white flex items-center gap-2">
                        <i class="fas fa-sync text-orange-400"></i>
                        {{ $todo->updated_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Completion Progress</h4>
                    <span class="text-lg font-bold text-blue-400">
                        @php
                            $percent = match($todo->progress) {
                                'pending' => 0,
                                'inprogress' => 50,
                                'completed' => 100,
                                default => 0,
                            };
                        @endphp
                        {{ $percent }}%
                    </span>
                </div>
                <div class="w-full h-3 bg-slate-700 rounded-full overflow-hidden border border-slate-600">
                    <div class="h-full transition-all duration-300 {{ $todo->progress == 'completed' ? 'bg-gradient-to-r from-green-500 to-green-400' : ($todo->progress == 'inprogress' ? 'bg-gradient-to-r from-yellow-500 to-yellow-400' : 'bg-gradient-to-r from-gray-500 to-gray-400') }}"
                         style="width: {{ $percent }}%">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 justify-between flex-wrap">
                <a href="{{ route('todo.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('todo.edit', $todo->id) }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg text-white font-semibold transition flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit Task
                    </a>

                    <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg text-white font-semibold transition flex items-center gap-2"
                                onclick="return confirm('Delete this task permanently?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
