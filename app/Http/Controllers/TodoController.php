<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::where(function ($q) {
            $q->where('user_id', Auth::id())
              ->orWhere('status', 'public');
        });

        //  Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $todos = $query->latest()
                       ->paginate(5)
                       ->withQueryString();

        return view('todo.list', compact('todos'));
    }

    public function create()
    {
        return view('todo.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress' => 'required|in:pending,inprogress,completed',
            'status' => 'required|in:public,private',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'progress' => $request->progress,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Task successfully added');
    }

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

    public function edit($id)
    {
        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress' => 'required|in:pending,inprogress,completed',
            'status' => 'required|in:public,private',
        ]);

        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'progress' => $request->progress,
            'status' => $request->status,
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        $todo = Todo::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $todo->delete();

        return redirect()->route('todo.index')
            ->with('success', 'Task deleted successfully');
    }

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
