@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5><i class="fa fa-edit"></i> Edit Todo</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('todo.update', $todo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">Todo Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ $todo->title }}"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- Completed -->
                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="completed"
                                   {{ $todo->completed ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Completed
                            </label>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="status" class="form-control">
                                <option value="private"
                                    {{ $todo->status == 'private' ? 'selected' : '' }}>
                                    Private
                                </option>
                                <option value="public"
                                    {{ $todo->status == 'public' ? 'selected' : '' }}>
                                    Public
                                </option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('todo.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
