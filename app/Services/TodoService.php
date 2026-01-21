<?php

namespace App\Services;

use App\Models\Todo;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * TodoService - Business Logic for Todo Management
 * 
 * Handles all todo operations, separating concerns from controller
 */
class TodoService
{
    /**
     * Get user's todos with overdue tracking
     * 
     * @param int $userId - Authenticated user ID
     * @param array $filters - Search and sort options
     * @return array - Contains paginated todos and overdue data
     */
    public function getUserTodos(int $userId, array $filters = []): array
    {
        // Validate and sanitize search input
        $search = $this->sanitizeSearch($filters['search'] ?? null);
        $perPage = $this->validatePerPage($filters['per_page'] ?? 10);

        // Build base query
        $query = $this->buildTodoQuery($userId);

        // Apply search filter
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Apply sorting
        $query = $this->applySorting($query);

        // Paginate results
        $todos = $query->paginate($perPage)->appends(request()->query());

        // Get overdue todos count (from paginated results to avoid extra query)
        $overdueCount = $todos->filter(function ($todo) {
            return $this->isOverdue($todo);
        })->count();

        // Get overdue todos for separate display
        $overdueTodos = $this->getOverdueTodos($userId);

        return [
            'todos' => $todos,
            'overdue_todos' => $overdueTodos,
            'overdue_count' => $overdueCount,
        ];
    }

    /**
     * Create a new todo
     * 
     * @param int $userId - Creator's user ID
     * @param array $data - Todo data
     * @return Todo - Created todo instance
     */
    public function createTodo(int $userId, array $data): Todo
    {
        // Sanitize inputs
        $data = $this->sanitizeTodoData($data);

        // Create with user association
        return Todo::create(array_merge($data, [
            'user_id' => $userId,
        ]));
    }

    /**
     * Update an existing todo
     * 
     * @param Todo $todo - Todo to update
     * @param array $data - Updated data
     * @return bool - Success status
     */
    public function updateTodo(Todo $todo, array $data): bool
    {
        // Sanitize inputs
        $data = $this->sanitizeTodoData($data);

        // Don't allow changing user_id
        unset($data['user_id']);

        return $todo->update($data);
    }

    /**
     * Delete a todo
     * 
     * @param Todo $todo - Todo to delete
     * @return bool - Success status
     */
    public function deleteTodo(Todo $todo): bool
    {
        return $todo->delete();
    }

    /**
     * Get single todo with visibility check
     * ✅ OPTIMIZED: Use model scope instead of manual query
     * 
     * @param int $todoId - Todo ID
     * @param int $userId - Current user ID
     * @return Todo|null - Todo if visible, null otherwise
     */
    public function getTodoWithVisibility(int $todoId, int $userId): ?Todo
    {
        return Todo::accessibleBy($userId)
            ->with(['comments.user' => function ($q) {
                $q->select('id', 'name', 'email', 'profile_photo');
            }])
            ->find($todoId);
    }

    /**
     * Add comment to public todo
     * 
     * @param int $todoId - Todo ID
     * @param int $userId - Commenter's user ID
     * @param string $comment - Comment text
     * @return Comment|false - Created comment or false
     */
    public function addComment(int $todoId, int $userId, string $comment): Comment|false
    {
        // Verify todo exists and is public
        $todo = Todo::where('id', $todoId)
                    ->where('status', 'public')
                    ->first();

        if (!$todo) {
            return false;
        }

        // Sanitize comment
        $comment = $this->sanitizeComment($comment);

        return Comment::create([
            'todo_id' => $todo->id,
            'user_id' => $userId,
            'comment' => $comment,
        ]);
    }

    /**
     * Get stats for dashboard
     * 
     * @param int $userId - User ID
     * @return array - Stats array
     */
    public function getStats(int $userId): array
    {
        $userTodos = Todo::where('user_id', $userId);

        return [
            'total' => $userTodos->count(),
            'completed' => $userTodos->where('progress', 'completed')->count(),
            'pending' => $userTodos->where('progress', 'pending')->count(),
            'in_progress' => $userTodos->where('progress', 'inprogress')->count(),
            'overdue' => $this->getOverdueCount($userId),
        ];
    }

    // ==================== HELPER METHODS ====================

    /**
     * Build base todo query
     * ✅ OPTIMIZED: Use model scope instead of manual query building
     */
    private function buildTodoQuery(int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return Todo::accessibleBy($userId);
    }

    /**
     * Apply all sorting rules
     */
    private function applySorting(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            // Overdue first
            ->orderByRaw(
                'CASE WHEN due_date < NOW() AND progress != ? THEN 0 ELSE 1 END',
                ['completed']
            )
            // By priority
            ->orderByRaw(
                'FIELD(priority, ?, ?, ?)',
                ['high', 'medium', 'low']
            )
            // By due date
            ->orderBy('due_date', 'asc')
            // Newest first
            ->latest('created_at');
    }

    /**
     * Get all overdue todos for a user
     * ✅ OPTIMIZED: Use model scope instead of manual query
     */
    private function getOverdueTodos(int $userId): Collection
    {
        return Todo::forUser($userId)
            ->overdue()
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Get overdue count
     * ✅ OPTIMIZED: Use model scope instead of manual query
     */
    private function getOverdueCount(int $userId): int
    {
        return Todo::forUser($userId)
            ->overdue()
            ->count();
    }

    /**
     * Check if todo is overdue
     * ✅ OPTIMIZED: Use model method instead of repeated logic
     */
    private function isOverdue(Todo $todo): bool
    {
        return $todo->isOverdue();
    }

    /**
     * Sanitize search input
     */
    private function sanitizeSearch(?string $search): ?string
    {
        if (!$search) {
            return null;
        }

        $search = trim($search);
        
        // Limit length
        if (strlen($search) > 255) {
            $search = substr($search, 0, 255);
        }

        // Remove special characters (optional, depends on requirements)
        // $search = preg_replace('/[^a-zA-Z0-9\s]/', '', $search);

        return $search ?: null;
    }

    /**
     * Sanitize comment text
     */
    private function sanitizeComment(string $comment): string
    {
        return trim(htmlspecialchars($comment, ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Sanitize todo data
     */
    private function sanitizeTodoData(array $data): array
    {
        return [
            'title' => trim($data['title'] ?? ''),
            'description' => trim($data['description'] ?? '') ?: null,
            'progress' => $data['progress'] ?? 'pending',
            'status' => $data['status'] ?? 'private',
            'due_date' => $data['due_date'] ?? null,
            'priority' => $data['priority'] ?? 'medium',
        ];
    }

    /**
     * Validate per_page parameter
     */
    private function validatePerPage(?int $perPage): int
    {
        if (!$perPage) {
            return 10;
        }

        // Limit between 5 and 100
        return max(5, min($perPage, 100));
    }


    
}
