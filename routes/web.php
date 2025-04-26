<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\GearsController;
use App\Http\Controllers\MasterData\LogisticsController;
use App\Http\Controllers\MasterData\MountainController;
use App\Http\Controllers\MasterData\PreparationController;
use App\Http\Controllers\MasterData\PreparationItemsController;
use App\Http\Controllers\MasterData\UserController;
use App\Http\Controllers\TrashBinController;
use App\Http\Middleware\OnlyAdmin;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('users')->name('users.')->middleware('only.admin')->group(function () {
        Route::resource('/', UserController::class)->parameters(['' => 'user']);
    });

    Route::middleware(['auth', OnlyAdmin::class])->group(function () {
        Route::get('recycle', [TrashBinController::class, 'recycle'])->name('users.recycle');
        Route::delete('users/${id}/force', [TrashBinController::class, 'forceDelete'])->name('users.force.delete');
        Route::patch('users/{id}/restore', [TrashBinController::class, 'restore'])->name('users.restore');
    });

    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/profile/{slug}', [UserController::class, 'show'])->name('users.profile');

    Route::prefix('mountain')->name('mountain.')->group(function () {
        Route::resource('', MountainController::class)->parameters(['' => 'mountain']);
        Route::delete('${id}/force', [MountainController::class, 'forceDelete'])->name('force.delete');
    });

    Route::prefix('gear')->name('gear.')->group(function () {
        Route::resource('', GearsController::class)->parameters(['' => 'gear']);
        Route::delete('${id}/force', [GearsController::class, 'forceDelete'])->name('force.delete');
    });

    Route::prefix('preparation')->name('preparation.')->group(function () {
        Route::resource('', PreparationController::class)->parameters(['' => 'preparation']);
        Route::post('/items/store', [PreparationItemsController::class, 'store'])->name('items.store');
        Route::put('/items/update/{preparation}', [PreparationItemsController::class, 'update'])->name('items.update');
        Route::resource('{preparation}/logistics', LogisticsController::class)->names('logistics');
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
