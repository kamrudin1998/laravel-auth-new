@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-6 py-10">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold mb-2 flex items-center">
                <i class="fas fa-edit text-purple-400 mr-3"></i> Edit Task
            </h1>
            <p class="text-gray-400">Update task details and status</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-lg shadow-2xl p-8 border border-slate-700">

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-900 border border-red-700 rounded-lg">
                    <h3 class="text-red-300 font-bold mb-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> Please fix the following errors:
                    </h3>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-200">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('todo.update', $todo->id) }}">
                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300">Task Title *</label>
                    <input type="text"
                           name="title"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition"
                           value="{{ old('title', $todo->title) }}"
                           required>
                    @error('title') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300">Description</label>
                    <textarea name="description"
                              class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition resize-none"
                              rows="4">{{ old('description', $todo->description) }}</textarea>
                    @error('description') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- PRIORITY & DUE DATE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- PRIORITY --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Priority *</label>
                        <select name="priority" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition" required>
                            <option value="low" {{ $todo->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $todo->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $todo->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- DUE DATE --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Due Date</label>
                        <input type="date"
                               name="due_date"
                               class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition"
                               value="{{ old('due_date', $todo->due_date) }}">
                        @error('due_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- PROGRESS & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- PROGRESS --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Progress *</label>
                        <select name="progress" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition" required>
                            <option value="pending" {{ $todo->progress == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inprogress" {{ $todo->progress == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $todo->progress == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('progress') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Visibility</label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition" required>
                            <option value="private" {{ $todo->status == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="public" {{ $todo->status == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                        @error('status') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex gap-3 justify-between">
                    <a href="{{ route('todo.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg text-white font-semibold transition transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-save"></i> Update Task
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
