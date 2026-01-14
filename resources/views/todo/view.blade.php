@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <!-- ================= TASK DETAILS ================= -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fa fa-eye"></i> Task Details</h5>
                </div>

                <div class="card-body">
                    <h4 class="mb-3">{{ $todo->title }}</h4>

                    <p class="text-muted">
                        {{ $todo->description ?? 'No description provided.' }}
                    </p>

                    <hr>

                    <p>
                        <strong>Visibility:</strong>
                        @if($todo->status === 'public')
                            <span class="badge bg-success">Public</span>
                        @else
                            <span class="badge bg-secondary">Private</span>
                        @endif
                    </p>

                    <p>
                        <strong>Status:</strong>
                        @if($todo->completed)
                            <span class="badge bg-primary">Completed</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </p>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('todo.index') }}" class="btn btn-secondary">Back</a>

                    @if(Auth::id() === $todo->user_id)
                        <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-primary">Edit</a>
                    @endif
                </div>
            </div>

            <!-- ================= COMMENTS (CHAT STYLE) ================= -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Comments ({{ $todo->comments->count() }})</h5>
                </div>

                <div class="card-body comment-box" style="max-height: 400px; overflow-y: auto;">
                    @forelse($todo->comments as $comment)
                        @php
                            $isMyComment = Auth::id() === $comment->user_id;
                        @endphp

                        <div class="d-flex mb-3 {{ $isMyComment ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="px-3 py-2 rounded shadow-sm"
                                 style="max-width:55%; background-color: {{ $isMyComment ? '#d1e7dd' : '#f1f1f1' }};">
                                <div class="small fw-bold">{{ $comment->user->name }}</div>
                                <div class="small text-muted mb-1">
                                    {{ $comment->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div>{{ $comment->comment }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No comments yet.</p>
                    @endforelse
                </div>

                @if($todo->status === 'public')
                    <div class="card-footer">
                        <form action="{{ route('todo.comment', $todo->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea name="comment" class="form-control" rows="1"
                                          placeholder="Type your comment..." required></textarea>
                                <button class="btn btn-success">Send</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card-footer text-muted text-center">
                        Comments are disabled for private tasks.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    const commentBox = document.querySelector('.comment-box');
    if (commentBox) {
        commentBox.scrollTop = commentBox.scrollHeight;
    }
</script>
@endsection
