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

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
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

                            @if(!empty($todo->description))
                                <small class="text-muted">
                                    {{ $todo->description }}
                                </small>
                            @else
                                <small class="text-muted fst-italic">
                                    No description
                                </small>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($todo->completed)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
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

                                <a href="{{ route('todo.show', $todo->id) }}"
                                     class="btn btn-sm btn-info">
                                     View
                                    </a>

                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <span class="text-muted">No todos found</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
