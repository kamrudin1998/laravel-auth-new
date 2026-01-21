@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-4 sm:px-6 py-8 sm:py-12">

    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2 flex items-center gap-3">
                <i class="fas fa-plus-circle text-green-400"></i> <span>Add New Task</span>
            </h1>
            <p class="text-gray-400 text-sm sm:text-base">Create a new task and organize your work efficiently</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-xl shadow-2xl p-6 sm:p-8 border border-slate-700">

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

            <form action="{{ route('todo.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                        <i class="fas fa-heading"></i> Task Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-500 text-sm sm:text-base"
                           placeholder="Enter a descriptive task title..."
                           value="{{ old('title') }}"
                           required>
                    @error('title') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                        <i class="fas fa-align-left"></i> Description
                    </label>
                    <textarea name="description"
                              class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-500 resize-none text-sm sm:text-base"
                              rows="4"
                              placeholder="Add optional details about your task...">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Due Date & Priority Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-calendar"></i> Due Date
                        </label>
                        <input type="date"
                               name="due_date"
                               class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base"
                               value="{{ old('due_date') }}">
                        @error('due_date') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-flag"></i> Priority <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="">Select priority...</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                🟢 Low Priority
                            </option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                🟡 Medium Priority (Default)
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                🔴 High Priority
                            </option>
                        </select>
                        @error('priority') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Progress & Visibility Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Progress Status -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-spinner"></i> Progress <span class="text-red-500">*</span>
                        </label>
                        <select name="progress" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="pending" {{ old('progress') == 'pending' ? 'selected' : '' }}>📋 Pending</option>
                            <option value="inprogress" {{ old('progress') == 'inprogress' ? 'selected' : '' }}>⚙️ In Progress</option>
                            <option value="completed" {{ old('progress') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                        </select>
                        @error('progress') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Visibility Status -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-blue-300 flex items-center gap-2">
                            <i class="fas fa-eye"></i> Visibility <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border-2 border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base" required>
                            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>🔒 Private (Only you)</option>
                            <option value="public" {{ old('status') == 'public' ? 'selected' : '' }}>🌍 Public (Anyone can comment)</option>
                        </select>
                        @error('status') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 justify-between flex-col sm:flex-row">
                    <a href="{{ route('todo.index') }}" class="order-2 sm:order-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 active:scale-95 rounded-lg text-white font-semibold transition flex items-center justify-center gap-2 text-sm sm:text-base">
                        <i class="fas fa-arrow-left"></i> <span>Back</span>
                    </a>
                    <button type="submit" class="order-1 sm:order-2 px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 active:scale-95 rounded-lg text-white font-semibold transition transform flex items-center justify-center gap-2 text-sm sm:text-base shadow-lg">
                        <i class="fas fa-check-circle"></i> <span>Create Task</span>
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>
@endsection
