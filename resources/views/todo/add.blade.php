@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-plus"></i> Add New Task
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('todo.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   placeholder="Enter task title"
                                   required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Optional description"></textarea>
                        </div>

                        <!-- Progress Status -->
                        <div class="mb-3">
                            <label class="form-label">Progress Status</label>
                            <select name="completed" class="form-control">
                                <option value="0">Pending</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>

                        <!-- Visibility Status -->
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="status" class="form-control">
                                <option value="private">Private</option>
                                <option value="public">Public</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('todo.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>
                            <button type="submit"
                                    class="btn btn-success">
                                Add Task
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
