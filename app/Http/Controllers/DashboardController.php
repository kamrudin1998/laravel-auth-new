<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalTasks = Todo::where('user_id', $userId)->count();

        $completedTasks = Todo::where('user_id', $userId)
            ->where('progress', 'completed')
            ->count();

        $pendingTasks = Todo::where('user_id', $userId)
            ->where('progress', '!=', 'completed')
            ->count();

        $overdueTasks = Todo::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->where('progress', '!=', 'completed')
            ->count();

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'overdueTasks'
        ));
    }
}
