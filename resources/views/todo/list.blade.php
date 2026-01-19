@extends('layouts.app')

@section('content')

<style>
    body {
        background: #0f172a;
    }

    .task-card {
        background: #ffffff;
        border-radius: 10px;
        border-left: 4px solid #2563eb;
    }

    .overdue-card {
        background: #fff1f2;
        border-left: 5px solid #dc2626;
        border-radius: 10px;
    }

    .task-meta {
        font-size: 13px;
        color: #6b7280;
    }

    .task-actions .btn {
        font-size: 12px;
        padding: 4px 10px;
    }

    .search-sort input,
    .search-sort select {
        height: 38px;
    }

    .progress-bar {
        transition: width 0.4s ease;
    }
</style>

<div class="container mt-4 position-relative">

    <!-- Floating Add Button -->
    <a href="{{ route('todo.create') }}"
       class="btn btn-success rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
       style="bottom:30px; right:30px; width:54px; height:54px; z-index:999;">
        <i class="fa fa-plus"></i>
    </a>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-white mb-0">
            <i class="fa fa-list me-2"></i>My Tasks
        </h4>
    </div>

    {{-- ================= SEARCH & SORT ================= --}}
    <form method="GET" class="row g-2 align-items-center search-sort mb-4">
        <div class="col-md-5">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search tasks…">
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Sort</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-primary px-4">
                <i class="fa fa-search"></i> Search
            </button>

            <a href="{{ route('todo.index') }}" class="btn btn-outline-light px-3">
                Reset
            </a>
        </div>
    </form>

    {{-- ================= OVERDUE ================= --}}
    @if($overdueTodos->count())
        <h6 class="text-danger fw-bold mb-2">
            <i class="fa fa-exclamation-circle me-1"></i>Overdue
        </h6>

        @foreach($overdueTodos as $todo)
            <div class="overdue-card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $todo->title }}</strong>
                        <div class="task-meta">
                            Due {{ $todo->due_date }} · {{ ucfirst($todo->progress) }}
                        </div>
                    </div>

                    <a href="{{ route('todo.show', $todo->id) }}"
                       class="btn btn-sm btn-danger">
                        Fix
                    </a>
                </div>
            </div>
        @endforeach
    @endif

    {{-- ================= TASK LIST ================= --}}
    @foreach($todos as $todo)
        <div class="task-card p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center">

                <div style="width: 100%;">
                    <strong>{{ $todo->title }}</strong>

                    @if($todo->priority == 'high')
                        <span class="badge bg-danger ms-1">High</span>
                    @elseif($todo->priority == 'medium')
                        <span class="badge bg-warning text-dark ms-1">Medium</span>
                    @else
                        <span class="badge bg-success ms-1">Low</span>
                    @endif

                    <div class="task-meta mt-1">
                        {{ $todo->due_date ?? 'No due date' }} · {{ ucfirst($todo->progress) }}
                    </div>

                    {{-- ===== Progress Percentage ===== --}}
                    @php
                        $percent = match($todo->progress) {
                            'pending' => 0,
                            'inprogress' => 50,
                            'completed' => 100,
                            default => 0,
                        };
                    @endphp

                    <div class="progress mt-2" style="height:6px; max-width:220px;">
                        <div class="progress-bar
                            @if($todo->progress == 'completed') bg-success
                            @elseif($todo->progress == 'inprogress') bg-warning
                            @else bg-secondary @endif"
                            role="progressbar"
                            style="width: {{ $percent }}%">
                        </div>
                    </div>

                    <small class="text-muted">{{ $percent }}% completed</small>
                </div>

                <div class="task-actions btn-group btn-group-sm ms-3">
                    <a href="{{ route('todo.show', $todo->id) }}"
                       class="btn btn-outline-primary">
                        View
                    </a>

                    @if($todo->user_id == auth()->id())
                        <a href="{{ route('todo.edit', $todo->id) }}"
                           class="btn btn-outline-secondary">
                            Edit
                        </a>

                        <form action="{{ route('todo.destroy', $todo->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger"
                                    onclick="return confirm('Delete task?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    @endforeach

    {{ $todos->links() }}

</div>
@endsection
