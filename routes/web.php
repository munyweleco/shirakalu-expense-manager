<?php

use App\Http\Controllers\StaffTypeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('staff-type')->middleware(['auth'])->group(function () {
    Route::get('/', [StaffTypeController::class, 'index'])->name('staff-type.index');

    Route::get('create', [StaffTypeController::class, 'create'])->name('staff-type.create');
    Route::post('/', [StaffTypeController::class, 'store'])->name('staff-type.store');

    Route::get('/{staff}', [StaffTypeController::class, 'show'])->name('staff-type.show');

    Route::get('/{staff}/edit', [StaffTypeController::class, 'edit'])->name('staff-type.edit');
    Route::put('/{staff}', [StaffTypeController::class, 'update'])->name('staff-type.update');

    Route::delete('/{staff}/delete', [StaffTypeController::class, 'destroy'])->name('staff-type.destroy');


});

Route::prefix('users')->middleware(['auth'])->group(function () {
    // Index route
    Route::get('/', [UsersController::class, 'index'])->name('users.index');

    // Show route
    Route::get('/{user}', [UsersController::class, 'show'])->name('users.show');

    // Edit route
    Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UsersController::class, 'update'])->name('users.update');

    // Delete route
    Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
});
