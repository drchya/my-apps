<?php

use App\Http\Controllers\MasterData\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('users')->name('users.')->group(function () {
        Route::resource('/', UserController::class)->parameters(['' => 'user']);
        Route::get('profile/{user}', [UserController::class, 'profile'])->name('profile');
    });
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/authenticate', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    if (App\Models\User::count() > 0) {
        return redirect('/login');
    }

    return app(AuthController::class)->register();
})->name('register');
Route::post('/register/store', [AuthController::class, 'store'])->name('register.process');

Route::get('/forgot-password', [AuthController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
