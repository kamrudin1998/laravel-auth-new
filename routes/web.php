<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

    Route::get('/dashboard', [TodoController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('todo', TodoController::class);
});

    Route::get('/todo/{id}', [TodoController::class, 'show'])
    ->name('todo.show');
    
    Route::post('/todo/{id}/comment', [TodoController::class, 'storeComment'])
    ->name('todo.comment');




require __DIR__.'/auth.php';
