<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// complete profile
Route::group(['prefix'=> 'profile'], function () {
    Route::get('/', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
    Route::get('/update', [ProfileController::class, 'showEditProfile'])->middleware('auth')->name('profile.edit');
    Route::post('/update', [ProfileController::class, 'updateProfile'])->middleware('auth')->name('profile.update');
    Route::post('/cover', [ProfileController::class, 'updateCover'])->middleware('auth')->name('profile.cover');
    Route::post('/self', [ProfileController::class, 'updateProfileImage'])->middleware('auth')->name('profile.self');

 });

//  post routes
Route::group(['prefix'=> 'post'], function () {
    Route::post('/store', [PostController::class,'store'])->middleware('auth')->name('post.store');
});


Route::get('/index', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');


require __DIR__.'/auth.php';
