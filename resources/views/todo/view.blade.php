@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4>{{ $todo->title }}</h4>

            <p>{{ $todo->description }}</p>

            <p>
                <strong>Priority:</strong>
                <span class="badge 
                    {{ $todo->priority == 'high' ? 'bg-danger' :
                       ($todo->priority == 'medium' ? 'bg-warning text-dark' : 'bg-success') }}">
                    {{ ucfirst($todo->priority) }}
                </span>
            </p>

            <p>
                <strong>Due Date:</strong>
                {{ $todo->due_date ?? 'Not set' }}
            </p>

            <p>
                <strong>Progress:</strong> {{ ucfirst($todo->progress) }}
            </p>

            @if($todo->due_date && $todo->due_date < now()->toDateString())
                <span class="badge bg-dark">Overdue</span>
            @endif

        </div>
    </div>

</div>
@endsection
