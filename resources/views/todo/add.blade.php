@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-6 py-10">

    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold mb-2 flex items-center">
                <i class="fas fa-plus-circle text-green-400 mr-3"></i> Add New Task
            </h1>
            <p class="text-gray-400">Create a new task and organize your work</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-lg shadow-2xl p-8 border border-slate-700">

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

            <form action="{{ route('todo.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300">Task Title *</label>
                    <input type="text"
                           name="title"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition"
                           placeholder="Enter task title..."
                           value="{{ old('title') }}"
                           required>
                    @error('title') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300">Description</label>
                    <textarea name="description"
                              class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition resize-none"
                              rows="4"
                              placeholder="Optional description...">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Due Date & Priority Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Due Date</label>
                        <input type="date"
                               name="due_date"
                               class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition"
                               value="{{ old('due_date') }}">
                        @error('due_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Priority *</label>
                        <select name="priority" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition" required>
                            <option value="">Select priority...</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-down"></i> Low
                            </option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                <i class="fas fa-minus"></i> Medium (Default)
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-up"></i> High
                            </option>
                        </select>
                        @error('priority') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Progress & Visibility Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Progress Status -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Progress Status *</label>
                        <select name="progress" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition" required>
                            <option value="pending" {{ old('progress') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inprogress" {{ old('progress') == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('progress') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('progress') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Visibility Status -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300">Visibility</label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:border-blue-500 transition">
                            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="public" {{ old('status') == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                        @error('status') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 justify-between">
                    <a href="{{ route('todo.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg text-white font-semibold transition transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-check"></i> Add Task
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>
@endsection
