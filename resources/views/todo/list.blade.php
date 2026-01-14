@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-list-check"></i> My Task's
            </h5>

            <a href="{{ route('todo.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add Task
            </a>
        </div>

        <div class="card-body">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="GET" action="{{ route('todo.index') }}" class="row mb-3">

    <div class="col-md-4">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Search task title..."
               value="{{ request('search') }}">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('todo.index') }}" class="btn btn-secondary">
                Clear
            </a>
        @endif
    </div>

</form>
    <table class="table table-hover table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th class="text-start">Task</th>
                <th>Status</th>
                <th width="22%">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($todos as $todo)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- TITLE + DESCRIPTION --}}
                    <td class="text-start">
                        <strong>{{ $todo->title }}</strong><br>
                        <small class="text-muted">
                            {{ $todo->description ?? 'No description' }}
                        </small>
                    </td>

                    {{-- PROGRESS STATUS --}}
                    <td>
                        @switch($todo->progress ?? 'pending')
                            @case('pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                    @break

                                @case('inprogress')
                                    <span class="badge bg-info text-dark">In Progress</span>
                                    @break

                                @case('completed')
                                    <span class="badge bg-success">Completed</span>
                                    @break

                                @default
                                    <span class="badge bg-secondary">Unknown</span>
                            @endswitch
                        </td>

                        {{-- ACTION BUTTONS --}}
                        <td>
                            {{-- EDIT & DELETE: ONLY OWNER --}}
                            @if($todo->user_id === Auth::id())
                                <a href="{{ route('todo.edit', $todo->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('todo.destroy', $todo->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- VIEW: EVERYONE --}}
                            <a href="{{ route('todo.show', $todo->id) }}"
                               class="btn btn-info btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">
                            No todos found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if ($todos->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="text-muted small">
            Showing {{ $todos->firstItem() }} to {{ $todos->lastItem() }}
            of {{ $todos->total() }} results
        </div>

        <div>
            {{ $todos->links() }}
        </div>

    </div>
@endif


        </div>
    </div>

</div>
@endsection
