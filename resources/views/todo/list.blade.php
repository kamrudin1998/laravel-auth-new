@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-list-check"></i> My Todos
            </h5>

            <a href="{{ route('todo.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add Todo
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

            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th class="text-start">Task</th>
                        <th>Status</th>
                        <th width="18%">Action</th>
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
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                    @break

                                @case('inprogress')
                                    <span class="badge bg-info text-dark">
                                        In Progress
                                    </span>
                                    @break

                                @case('completed')
                                    <span class="badge bg-success">
                                        Completed
                                    </span>
                                    @break

                                @default
                                    <span class="badge bg-secondary">
                                        Unknown
                                    </span>
                            @endswitch
                        </td>

                        {{-- ACTION --}}
                        <td>
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

        </div>
    </div>

</div>
@endsection
