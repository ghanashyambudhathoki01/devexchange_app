<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('questions', QuestionController::class)->except(['index']);
Route::get('/questions/{slug}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/questions/{slug}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('/questions/{slug}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/questions/{slug}', [QuestionController::class, 'destroy'])->name('questions.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::put('/answers/{answer}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
    Route::post('/answers/{answer}/best', [AnswerController::class, 'markBest'])->name('answers.best');
    
    Route::post('/vote', [VoteController::class, 'store'])->name('vote');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
});

Route::get('/tags/{slug}', [TagController::class, 'show'])->name('tags.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('tags', AdminTagController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
});

require __DIR__.'/auth.php';
