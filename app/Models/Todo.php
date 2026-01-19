<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function progressPercent()
    {
        return match ($this->progress) {
            'pending' => 0,
            'inprogress' => 50,
            'completed' => 100,
            default => 0,
        };  
    }
}
