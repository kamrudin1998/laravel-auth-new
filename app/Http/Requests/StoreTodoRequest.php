<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreTodoRequest - Centralized validation for todo creation and updates
 * ✅ OPTIMIZATION: Reduces validation code duplication
 */
class StoreTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'progress' => 'required|in:pending,inprogress,completed',
            'status' => 'required|in:public,private',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    /**
     * Get custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required',
            'title.max' => 'Task title must not exceed 255 characters',
            'description.max' => 'Description must not exceed 1000 characters',
            'progress.required' => 'Progress status is required',
            'progress.in' => 'Invalid progress status',
            'status.required' => 'Visibility status is required',
            'status.in' => 'Invalid visibility status',
            'due_date.date' => 'Due date must be a valid date',
            'due_date.after_or_equal' => 'Due date must be today or later',
            'priority.required' => 'Priority is required',
            'priority.in' => 'Invalid priority level',
        ];
    }
}
