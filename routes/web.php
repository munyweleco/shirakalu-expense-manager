<?php

use App\Http\Controllers\StaffTypeController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [StaffTypeController::class, 'index'])->name('staff-type.index');
Route::get('/staff-type/create', [StaffTypeController::class, 'store'])->name('staff-type.create');
Route::get('/staff-type/{staff}', [StaffTypeController::class, 'show'])->name('staff-type.show');
Route::get('/staff-type/{staff}/edit', [StaffTypeController::class, 'edit'])->name('staff-type.edit');
Route::put('/staff-type/{staff}', [StaffTypeController::class, 'update'])->name('staff-type.update');
Route::delete('/staff-type/{staff}', [StaffTypeController::class, 'destroy'])->name('staff-type.destroy');


//// returns the form for adding a post
//Route::get('/posts/create', PostController::class . '@create')->name('posts.create');
//// adds a post to the database
//Route::post('/posts', PostController::class .'@store')->name('posts.store');
//// returns a page that shows a full post
//Route::get('/posts/{post}', PostController::class .'@show')->name('posts.show');
//// returns the form for editing a post
//Route::get('/posts/{post}/edit', PostController::class .'@edit')->name('posts.edit');
//// updates a post
//Route::put('/posts/{post}', PostController::class .'@update')->name('posts.update');
//// deletes a post
//Route::delete('/posts/{post}', PostController::class .'@destroy')->name('posts.destroy');
