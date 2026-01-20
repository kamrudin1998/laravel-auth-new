@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-6 sm:px-10 py-10">

    <!-- Welcome Section -->
    <div class="mb-12">
        <h1 class="text-4xl sm:text-5xl font-bold mb-2">
            <i class="fas fa-wave-hand text-yellow-400 mr-3"></i>Welcome, {{ Auth::user()->name }}
        </h1>
        <p class="text-gray-400">Here's your task overview for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

        <!-- Total Tasks -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105 border border-blue-500">
            <div class="flex items-center justify-between mb-4">
                <p class="text-blue-100 font-semibold">Total Tasks</p>
                <i class="fas fa-tasks text-blue-200 text-2xl opacity-50"></i>
            </div>
            <h3 class="text-4xl font-bold text-white">{{ $totalTasks }}</h3>
            <p class="text-blue-100 text-sm mt-2">All your tasks</p>
        </div>

        <!-- Completed -->
        <div class="bg-gradient-to-br from-green-600 to-green-700 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105 border border-green-500">
            <div class="flex items-center justify-between mb-4">
                <p class="text-green-100 font-semibold">Completed</p>
                <i class="fas fa-check-circle text-green-200 text-2xl opacity-50"></i>
            </div>
            <h3 class="text-4xl font-bold text-white">{{ $completedTasks }}</h3>
            <p class="text-green-100 text-sm mt-2">Well done!</p>
        </div>

        <!-- Pending -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105 border border-yellow-400">
            <div class="flex items-center justify-between mb-4">
                <p class="text-yellow-100 font-semibold">Pending</p>
                <i class="fas fa-hourglass-half text-yellow-100 text-2xl opacity-50"></i>
            </div>
            <h3 class="text-4xl font-bold text-white">{{ $pendingTasks }}</h3>
            <p class="text-yellow-100 text-sm mt-2">In your queue</p>
        </div>

        <!-- Overdue -->
        <div class="bg-gradient-to-br from-red-600 to-red-700 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105 border border-red-500">
            <div class="flex items-center justify-between mb-4">
                <p class="text-red-100 font-semibold">Overdue</p>
                <i class="fas fa-exclamation-circle text-red-200 text-2xl opacity-50"></i>
            </div>
            <h3 class="text-4xl font-bold text-white">{{ $overdueTasks }}</h3>
            <p class="text-red-100 text-sm mt-2">Need attention</p>
        </div>

    </div>

    <!-- CTA Section -->
    <div class="flex justify-center">
        <a href="{{ route('todo.index') }}"
           class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition transform hover:scale-105 shadow-lg">
            <i class="fas fa-list mr-2"></i> View All Tasks
        </a>
    </div>

</div>
@endsection
