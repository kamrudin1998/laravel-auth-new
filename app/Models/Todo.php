<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'progress',
        'status',
        'due_date',
        'priority'
    ];

    // ✅ OPTIMIZATION: Cast due_date to Carbon instance for date operations
    protected $casts = [
        'due_date' => 'date',
    ];

    // 🔗 Todo belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Todo has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ==================== QUERY SCOPES ====================
    
    /**
     * Scope: Filter todos belonging to a specific user
     * ✅ OPTIMIZATION: Reusable scope for user-specific queries
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter todos owned by user or public
     * ✅ OPTIMIZATION: Reduces code duplication for access control
     */
    public function scopeAccessibleBy(Builder $query, int $userId): Builder
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('status', 'public');
        });
    }

    /**
     * Scope: Filter overdue incomplete todos
     * ✅ OPTIMIZATION: Reusable scope for overdue queries
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNotNull('due_date')
                     ->whereDate('due_date', '<', today())
                     ->where('progress', '!=', 'completed');
    }

    /**
     * Scope: Filter completed todos
     * ✅ OPTIMIZATION: Reusable scope
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('progress', 'completed');
    }

    /**
     * Scope: Filter incomplete todos
     * ✅ OPTIMIZATION: Reusable scope
     */
    public function scopeIncomplete(Builder $query): Builder
    {
        return $query->where('progress', '!=', 'completed');
    }

    /**
     * Scope: Filter by priority
     * ✅ OPTIMIZATION: Reusable scope
     */
    public function scopeByPriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    // ==================== HELPER METHODS ====================

    public function progressPercent(): int
    {
        return match ($this->progress) {
            'pending' => 0,
            'inprogress' => 50,
            'completed' => 100,
            default => 0,
        };  
    }

    /**
     * Check if todo is overdue
     * ✅ OPTIMIZATION: Use model method instead of repeated logic
     */
    public function isOverdue(): bool
    {
        return $this->due_date 
            && $this->due_date->toDateString() < today()->toDateString()
            && $this->progress !== 'completed';
    }

    /**
     * Check if user can access this todo
     * ✅ OPTIMIZATION: Centralized access control logic
     */
    public function canBeAccessedBy(int $userId): bool
    {
        return $this->user_id === $userId || $this->status === 'public';
    }

    /**
     * Check if user owns this todo
     * ✅ OPTIMIZATION: Centralized ownership check
     */
    public function isOwnedBy(int $userId): bool
    {
        return $this->user_id === $userId;
    }
}
