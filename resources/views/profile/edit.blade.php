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
        <div class="bg-slate-800 rounded-lg shadow-lg p-8 mb-6 border border-slate-700 hover:border-slate-600 transition">
            <h5 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-400 mr-3"></i>Profile Information
            </h5>

            <form method="POST"
                  action="{{ route('profile.update') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- PROFILE PHOTO --}}
                <div class="mb-8 text-center">
                    <div class="mb-4">
                        <img
                            src="{{ auth()->user()->profile_photo
                                ? asset('storage/' . auth()->user()->profile_photo)
                                : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                            width="140"
                            height="140"
                            class="rounded-full mb-4 inline-block border-4 border-blue-500 shadow-lg"
                            style="object-fit:cover;">
                    </div>
                    <label class="block text-sm font-medium mb-3">Change Profile Photo</label>
                    <input type="file"
                           name="profile_photo"
                           accept="image/*"
                           class="block w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-blue-500 text-sm">
                    <p class="text-xs text-gray-400 mt-2">JPG, PNG or GIF (Max: 2MB)</p>
                </div>

                {{-- NAME --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2">Full Name</label>
                    <input type="text"
                           name="name"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-blue-500 transition"
                           value="{{ old('name', auth()->user()->name) }}"
                           required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Email Address</label>
                    <input type="email"
                           name="email"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-blue-500 transition"
                           value="{{ old('email', auth()->user()->email) }}"
                           required>
                </div>

                {{-- Success Message --}}
                @if (session('status') === 'profile-updated')
                    <div class="mb-4 p-4 bg-green-900 border border-green-700 rounded-lg text-green-100 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> Profile updated successfully!
                    </div>
                @endif

                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg text-white font-semibold transition transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>

        {{-- ================= PASSWORD UPDATE ================= --}}
        <div class="bg-slate-800 rounded-lg shadow-lg p-8 mb-6 border border-slate-700 hover:border-slate-600 transition">
            <h5 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-lock text-yellow-400 mr-3"></i>Update Password
            </h5>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')5">
                    <label class="block text-sm font-medium mb-2">Current Password</label>
                    <input type="password"
                           name="current_password"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-yellow-500 transition"
                           required>
                    @error('current_password') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2">New Password</label>
                    <input type="password"
                           name="password"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-yellow-500 transition"
                           required>
                    @error('password') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-yellow-500 transition"
                           required>
                    @error('password_confirmation') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Success Message --}}
                @if (session('status') === 'password-updated')
                    <div class="mb-4 p-4 bg-green-900 border border-green-700 rounded-lg text-green-100 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> Password updated successfully!
                    </div>
                @endif
8 border-l-4 border-red-600 hover:border-red-500 transition">
            <h5 class="text-2xl font-bold mb-4 flex items-center text-red-400">
                <i class="fas fa-trash-alt mr-3"></i>Delete Account
            </h5>

            <p class="text-red-300 mb-6 leading-relaxed">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Deleting your account is permanent. All your tasks and data will be permanently removed and cannot be recover
                </button>
            </form>
        </div>

        {{-- ================= DELETE ACCOUNT ================= --}}
        <div class="bg-slate-800 rounded-lg shadow-lg p-6 border-l-4 border-red-600">
            <h5 class="text-2xl font-bold mb-4 text-red-400">Delete Account</h5>

            <p class="text-red-300 mb-6">
                Once your account is deleted, all data will be permanently removed.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')Enter your password to confirm deletion:</label>
                    <input type="password"
                           name="password"
                           class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg border border-red-600 focus:outline-none focus:border-red-500 transition"
                           placeholder="Your password"
                           required>
                </div>

                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg text-white font-semibold transition transform hover:scale-105 flex items-center gap-2"
                        onclick="return confirm('⚠️ Are you absolutely sure? This action cannot be undone.')">
                    <i class="fas fa-check-circle"></i> Confirm Deletion
                <button class="px-6 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white transition"
                        onclick="return confirm('Are you sure? This action cannot be undone.')">
                    Delete Account
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
