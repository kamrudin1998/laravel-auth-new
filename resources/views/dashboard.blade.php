@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h3 class="fw-bold mb-4">
        Welcome, {{ Auth::user()->name }} 👋
    </h3>

    <div class="row g-4">

        {{-- TOTAL TASKS --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-tasks fa-2x text-primary mb-2"></i>
                    <h5>Total Tasks</h5>
                    <h3 class="fw-bold">{{ $totalTasks }}</h3>
                </div>
            </div>
        </div>

        {{-- COMPLETED --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-check-circle fa-2x text-success mb-2"></i>
                    <h5>Completed</h5>
                    <h3 class="fw-bold">{{ $completedTasks }}</h3>
                </div>
            </div>
        </div>

        {{-- PENDING --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-clock fa-2x text-warning mb-2"></i>
                    <h5>Pending</h5>
                    <h3 class="fw-bold">{{ $pendingTasks }}</h3>
                </div>
            </div>
        </div>

        {{-- OVERDUE --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h5>Overdue</h5>
                    <h3 class="fw-bold">{{ $overdueTasks }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- CTA --}}
    <div class="mt-5 text-center">
        <a href="{{ route('todo.index') }}" class="btn btn-primary btn-lg">
            <i class="fa fa-list me-2"></i> Go to My Tasks
        </a>
    </div>

</div>
@endsection
