@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header fw-bold">
                    Edit Todo
                </div>

                <div class="card-body">

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('todo.update', $todo->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- TITLE --}}
                        <div class="mb-3">
                            <label class="form-label">Todo Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title', $todo->title) }}"
                                   required>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="3">{{ old('description', $todo->description) }}</textarea>
                        </div>

                        {{-- PROGRESS --}}
                        <div class="mb-3">
                            <label class="form-label">Progress</label>
                            <select name="progress" class="form-select" required>
                                <option value="pending" {{ $todo->progress == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="inprogress" {{ $todo->progress == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $todo->progress == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        {{-- PRIORITY --}}
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select" required>
                                <option value="low" {{ $todo->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $todo->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $todo->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        {{-- DUE DATE --}}
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date"
                                   name="due_date"
                                   class="form-control"
                                   value="{{ old('due_date', $todo->due_date) }}">
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="status" class="form-select" required>
                                <option value="private" {{ $todo->status == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="public" {{ $todo->status == 'public' ? 'selected' : '' }}>Public</option>
                            </select>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('todo.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
