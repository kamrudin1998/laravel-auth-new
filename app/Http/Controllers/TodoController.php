<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('status', 'public');
            })
            ->latest()
            ->get();

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
            'status' => 'required|in:public,private',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'completed' => false,
            'status' => $request->status,
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo successfully added');
    }

    public function show($id)
    {
        $todo = Todo::where('user_id', Auth::id())
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
            'status' => 'required|in:public,private',
        ]);

        $todo = Todo::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->firstOrFail();

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->has('completed'),
            'status' => $request->status,
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo updated successfully');
    }

    public function destroy($id)
    {
        $todo = Todo::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->firstOrFail();

        $todo->delete();

        return redirect()->route('todo.index')
            ->with('success', 'Todo deleted successfully');
    }
}
