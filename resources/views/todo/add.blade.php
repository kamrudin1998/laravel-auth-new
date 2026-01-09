@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5><i class="fa fa-plus"></i> Add Todo</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('todo.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Todo Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter task" required>
                        </div>

                        <!-- ✅ DESCRIPTION FIELD -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea 
                                name="description" 
                                class="form-control" 
                                rows="3"
                                placeholder="Enter description (optional)">
                            </textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('todo.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
