<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Comment;
use App\Services\TodoService;
use App\Http\Requests\StoreTodoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Inject TodoService
     */
    public function __construct(protected TodoService $todoService)
    {
    }

    /**
     * Display list of todos with filtering and sorting
     * ✅ OPTIMIZED: Delegates to service for cleaner controller
     */
    public function index(Request $request)
    {
        $data = $this->todoService->getUserTodos(
            auth()->id(),
            [
                'search' => $request->input('search'),
                'per_page' => $request->input('per_page', 10),
            ]
        );

        return view('todo.list', [
            'todos' => $data['todos'],
            'overdueTodos' => $data['overdue_todos'],
            'overdueCount' => $data['overdue_count'],
        ]);
    }
    public function create()
    {
        return view('todo.add');
    }

    /**
     * Store new todo
     * ✅ OPTIMIZED: Uses centralized StoreTodoRequest for validation
     */
    public function store(StoreTodoRequest $request)
    {
        $this->todoService->createTodo(auth()->id(), $request->validated());

        return redirect()->route('todo.index')
            ->with('success', 'Task successfully added');
    }

    /**
     * View single todo
     */
    public function show($id)
    {
        $todo = $this->todoService->getTodoWithVisibility($id, auth()->id());

        if (!$todo) {
            abort(404, 'Todo not found or not accessible');
        }

        return view('todo.view', compact('todo'));
    }

    /**
     * Show edit form (owner only)
     * ✅ OPTIMIZED: Use model scope + authorization
     */
    public function edit($id)
    {
        $todo = Todo::forUser(auth()->id())
            ->findOrFail($id);

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update todo
     * ✅ OPTIMIZED: Use model scope + centralized validation
     */
    public function update(StoreTodoRequest $request, $id)
    {
        // Get todo and check ownership using scope
        $todo = Todo::forUser(auth()->id())
            ->findOrFail($id);

        $this->todoService->updateTodo($todo, $request->validated());

        return redirect()->route('todo.index')
            ->with('success', 'Task updated successfully');
    }

    /**
     * Delete todo
     * ✅ OPTIMIZED: Use model scope
     */
    public function destroy($id)
    {
        $todo = Todo::forUser(auth()->id())
            ->findOrFail($id);

        $this->todoService->deleteTodo($todo);

        return redirect()->route('todo.index')
            ->with('success', 'Task deleted successfully');
    }

    /**
     * Store comment on public todo
     */
    public function storeComment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|min:1|max:1000',
        ]);

        $comment = $this->todoService->addComment(
            $id,
            auth()->id(),
            $validated['comment']
        );

        if (!$comment) {
            return redirect()->route('todo.index')
                ->with('error', 'Todo not found or not public');
        }

        return redirect()->route('todo.show', $id)
            ->with('success', 'Comment added successfully');
    }
}
