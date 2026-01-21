@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white px-6 py-10">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold mb-2">
                <i class="fas fa-user-circle mr-3 text-blue-400"></i>Profile Settings
            </h1>
            <p class="text-gray-400">Manage your account information and preferences</p>
        </div>

        {{-- ================= PROFILE INFO ================= --}}
        <div class="bg-slate-800 rounded-lg shadow-lg p-8 mb-6 border border-slate-700">
            <h5 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-400 mr-3"></i>Profile Information
            </h5>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3">📸 Profile Photo</label>
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <img src="{{ Auth::user()->profile_photo 
                                ? asset('storage/' . Auth::user()->profile_photo) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                 alt="Profile" class="w-24 h-24 rounded-full border-2 border-slate-600 object-cover">
                        </div>
                        <div class="flex-grow">
                            <input type="file" name="profile_photo" accept="image/*"
                                   class="block w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600 text-sm cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <p class="text-xs text-gray-400 mt-2">✓ PNG, JPG up to 2MB</p>
                            @error('profile_photo')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2">Full Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600"
                           required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600"
                           required>
                </div>

                <button class="px-6 py-3 bg-blue-600 rounded-lg font-semibold hover:bg-blue-700">
                    Save Changes
                </button>
            </form>
        </div>

        {{-- ================= PASSWORD UPDATE ================= --}}
        <div class="bg-slate-800 rounded-lg shadow-lg p-8 mb-6 border border-slate-700">
            <h5 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-lock text-yellow-400 mr-3"></i>Update Password
            </h5>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block mb-2">Current Password</label>
                    <input type="password" name="current_password"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600" required>
                </div>

                <div class="mb-5">
                    <label class="block mb-2">New Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600" required>
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-slate-600" required>
                </div>

                <button class="px-6 py-3 bg-yellow-600 rounded-lg font-semibold hover:bg-yellow-700">
                    Update Password
                </button>
            </form>
        </div>

        {{-- ================= DELETE ACCOUNT ================= --}}
        <div class="bg-slate-800 rounded-lg shadow-lg p-8 border-l-4 border-red-600">
            <h5 class="text-2xl font-bold mb-4 text-red-400">
                <i class="fas fa-trash mr-2"></i>Delete Account
            </h5>

            <p class="text-red-300 mb-6">
                Once your account is deleted, all data will be permanently removed.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="mb-6">
                    <label class="block mb-2">Confirm Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 bg-slate-700 rounded-lg border border-red-600"
                           placeholder="Your password" required>
                </div>

                <button type="submit"
                        onclick="return confirm('Are you sure? This action cannot be undone.')"
                        class="px-6 py-3 bg-red-600 rounded-lg font-semibold hover:bg-red-700">
                    Delete Account
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
