<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

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



