@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- ================= PROFILE INFO ================= --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5>Profile Information</h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ route('profile.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- PROFILE PHOTO --}}
                        <div class="mb-4 text-center">
                            <img
                                src="{{ auth()->user()->profile_photo
                                    ? asset('storage/' . auth()->user()->profile_photo)
                                    : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                                width="120"
                                height="120"
                                class="rounded-circle mb-3"
                                style="object-fit:cover;">

                            <div class="mb-2">
                                <input type="file"
                                       name="profile_photo"
                                       class="form-control">
                            </div>
                        </div>

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required>
                        </div>

                        <button class="btn btn-primary">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            {{-- ================= PASSWORD UPDATE ================= --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5>Update Password</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn btn-warning">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- ================= DELETE ACCOUNT ================= --}}
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5>Delete Account</h5>
                </div>

                <div class="card-body">
                    <p class="text-danger">
                        Once your account is deleted, all data will be permanently removed.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn btn-danger"
                                onclick="return confirm('Are you sure? This action cannot be undone.')">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
