<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\QuestionController as StudentQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/login', function () {
//     return view('about');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile/{id}', [ProfileController::class, 'showUser'])->name('profile.show');
        Route::get('profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update.password');
        Route::resource('questions', QuestionController::class);
        Route::resource('users', UserController::class);
        Route::post('users/update-status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    });

    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('questions',[QuestionController::class, 'index'])->name('questions.index');
    });

    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('questions', [StudentQuestionController::class, 'index'])->name('questions.index');
        Route::post('submit-exam',[StudentQuestionController::class,'submitExam'])->name('submit-exam');
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
