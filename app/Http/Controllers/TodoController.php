<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->latest()->get();
        return view('todo.list', compact('todos'));


        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todo.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'completed' => false,
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = Todo::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->firstOrFail();

        return view('todo.view', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $todo = Todo::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->firstOrFail();

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $todo = Todo::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->firstOrFail();

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->has('completed'),
        ]);

        return redirect()->route('todo.index')
            ->with('success', 'Todo successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
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
