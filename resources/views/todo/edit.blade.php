@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-4 sm:px-6 py-8 sm:py-12">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2 flex items-center gap-3">
                <i class="fas fa-edit text-purple-400"></i> <span>Edit Task</span>
            </h1>
            <p class="text-gray-400 text-sm sm:text-base">Update task details, priority, and status</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-700">

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-900 bg-opacity-30 border border-red-700 rounded-lg">
                    <h3 class="text-red-300 font-bold mb-3 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> <span>Please fix the following errors:</span>
                    </h3>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-200 text-sm">{{ $error }}</li>
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
                    <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                        <i class="fas fa-heading"></i> Task Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-500 text-sm sm:text-base"
                           value="{{ old('title', $todo->title) }}"
                           required>
                    @error('title') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                        <i class="fas fa-align-left"></i> Description
                    </label>
                    <textarea name="description"
                              class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-500 resize-none text-sm sm:text-base"
                              rows="4">{{ old('description', $todo->description) }}</textarea>
                    @error('description') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- PRIORITY & DUE DATE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- PRIORITY --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-flag"></i> Priority <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="low" {{ $todo->priority == 'low' ? 'selected' : '' }}>🟢 Low</option>
                            <option value="medium" {{ $todo->priority == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                            <option value="high" {{ $todo->priority == 'high' ? 'selected' : '' }}>🔴 High</option>
                        </select>
                        @error('priority') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- DUE DATE --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-calendar"></i> Due Date
                        </label>
                        <input type="date"
                               name="due_date"
                               class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base"
                               value="{{ old('due_date', $todo->due_date) }}">
                        @error('due_date') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- PROGRESS & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- PROGRESS --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-spinner"></i> Progress <span class="text-red-500">*</span>
                        </label>
                        <select name="progress" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="pending" {{ $todo->progress == 'pending' ? 'selected' : '' }}>📋 Pending</option>
                            <option value="inprogress" {{ $todo->progress == 'inprogress' ? 'selected' : '' }}>⚙️ In Progress</option>
                            <option value="completed" {{ $todo->progress == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                        </select>
                        @error('progress') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-eye"></i> Visibility <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="private" {{ $todo->status == 'private' ? 'selected' : '' }}>🔒 Private (Only you)</option>
                            <option value="public" {{ $todo->status == 'public' ? 'selected' : '' }}>🌍 Public (Anyone can comment)</option>
                        </select>
                        @error('status') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex gap-3 justify-between flex-col sm:flex-row">
                    <a href="{{ route('todo.index') }}" class="order-2 sm:order-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 active:scale-95 rounded-lg text-white font-semibold transition flex items-center justify-center gap-2 text-sm sm:text-base">
                        <i class="fas fa-arrow-left"></i> <span>Back</span>
                    </a>
                    <button type="submit" class="order-1 sm:order-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 active:scale-95 rounded-lg text-white font-semibold transition transform flex items-center justify-center gap-2 text-sm sm:text-base shadow-lg">
                        <i class="fas fa-save"></i> <span>Update Task</span>
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
