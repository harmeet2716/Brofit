<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DailyGoalController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\AiCoachController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard instantly
Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/exercises/{id}', [ExerciseController::class, 'show'])->name('exercises.show');
Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');

// 🔒 PROTECTED ACTIONS / PROFILE ROUTES (Only registered/logged-in users can access)
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Course enrollments
    Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Exercise add
    Route::post('/exercises/{id}/add-to-goals', [ExerciseController::class, 'addToGoals'])->name('exercises.add-to-goals');

    // Daily Goals
    Route::get('/daily-goals', [DailyGoalController::class, 'index'])->name('daily-goals.index');
    Route::post('/daily-goals', [DailyGoalController::class, 'store'])->name('daily-goals.store');
    Route::patch('/daily-goals/{id}', [DailyGoalController::class, 'update'])->name('daily-goals.update');
    Route::delete('/daily-goals/{id}', [DailyGoalController::class, 'destroy'])->name('daily-goals.destroy');
    Route::post('/daily-goals/copy-yesterday', [DailyGoalController::class, 'copyYesterday'])->name('daily-goals.copy-yesterday');

    // Nutrition post/delete
    Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
    Route::delete('/nutrition/{id}', [NutritionController::class, 'destroy'])->name('nutrition.destroy');

    // AI Coach
    Route::get('/ai-coach', [AiCoachController::class, 'index'])->name('ai-coach.index');
    Route::post('/ai-coach/chat', [AiCoachController::class, 'chat'])->name('ai-coach.chat');
    Route::post('/ai-coach/plan', [AiCoachController::class, 'generatePlan'])->name('ai-coach.plan');
    Route::post('/ai-coach/clear', [AiCoachController::class, 'clearChat'])->name('ai-coach.clear');
});

require __DIR__ . '/auth.php';
