<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TodoApp - Manage Your Tasks</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <!-- Logo/Header -->
        <div class="text-center mb-12">
            <div class="text-6xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                <i class="fas fa-tasks mr-3"></i>TodoApp
            </div>
            <p class="text-gray-300 text-xl">Manage your tasks efficiently and stay organized</p>
        </div>

        <!-- Card Container -->
        <div class="bg-slate-800 rounded-2xl shadow-2xl p-8 max-w-md w-full mb-8 border border-slate-700">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-gray-300">Get started by logging in or creating an account</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full block px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg text-white font-semibold text-center transition transform hover:scale-105">
                            <i class="fas fa-arrow-right mr-2"></i> Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full block px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg text-white font-semibold text-center transition transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full block px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition transform hover:scale-105 border border-slate-600">
                                <i class="fas fa-user-plus mr-2"></i> Create Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-slate-700"></div>
                <span class="px-3 text-gray-400 text-sm">Features</span>
                <div class="flex-1 border-t border-slate-700"></div>
            </div>

            <!-- Features -->
            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-400 mt-1"></i>
                    <span class="text-gray-300">Create, manage, and track your tasks</span>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-400 mt-1"></i>
                    <span class="text-gray-300">Set priorities and due dates</span>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-400 mt-1"></i>
                    <span class="text-gray-300">Monitor your progress with stats</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-400 text-sm">
            <p>&copy; 2026 TodoApp. Organized productivity made simple.</p>
        </div>
    </div>
</body>
</html>