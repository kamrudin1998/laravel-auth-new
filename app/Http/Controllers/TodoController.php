<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Dashboard: user todos + public todos
     */
    public function index(Request $request)
    {
        // Base query (own + public todos)
        $query = Todo::where(function ($q) {
            $q->where('user_id', auth()->id())
              ->orWhere('status', 'public');
        });

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Main todos (sorted & paginated)
        $todos = $query
            // 1️⃣ Overdue tasks first
            ->orderByRaw("
                CASE 
                    WHEN due_date IS NOT NULL
                     AND due_date < CURDATE()
                     AND progress != 'completed'
                    THEN 0
                    ELSE 1
                END
            ")

            // Priority order
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ")

            // Nearest due date
            ->orderBy('due_date')

            // Newest first
            ->orderByDesc('created_at')

            ->paginate(5)
            ->withQueryString();

        //Overdue todos (list)
        $overdueTodos = Todo::where('user_id', auth()->id())
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->where('progress', '!=', 'completed')
            ->orderBy('due_date')
            ->get();

        //Overdue count (badge / stats)
        $overdueCount = Todo::where('user_id', auth()->id())
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->where('progress', '!=', 'completed')
            ->count();

        return view('todo.list', compact(
            'todos',
            'overdueTodos',
            'overdueCount'
        ));
    }
    public function create()
    {
        return view('todo.add');
    }

    /**
     * Store new todo
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress'    => 'required|in:pending,inprogress,completed',
            'status'      => 'required|in:public,private',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
        ]);

        Todo::create([
            'title'       => $request->title,
            'description' => $request->description,
            'progress'    => $request->progress,
            'status'      => $request->status,
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Task successfully added');
    }

    /**
     * View single todo
     */
    public function show($id)
    {
        $todo = Todo::with('comments.user')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                  ->orWhere('status', 'public');
            })
            ->where('id', $id)
            ->firstOrFail();

        return view('todo.view', compact('todo'));
    }

    /**
     * Show edit form (owner only)
     */
    public function edit($id)
    {
        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update todo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress'    => 'required|in:pending,inprogress,completed',
            'status'      => 'required|in:public,private',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $todo->update([
            'title'       => $request->title,
            'description' => $request->description,
            'progress'    => $request->progress,
            'status'      => $request->status,
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Task updated successfully');
    }

    /**
     * Delete todo
     */
    public function destroy($id)
    {
        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $todo->delete();

        return redirect()->route('todo.index')
            ->with('success', 'Task deleted successfully');
    }

    /**
     * Store comment on public todo
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $todo = Todo::where('id', $id)
            ->where('status', 'public')
            ->firstOrFail();

        Comment::create([
            'todo_id' => $todo->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('todo.show', $id)
            ->with('success', 'Comment added successfully');
    }
}
