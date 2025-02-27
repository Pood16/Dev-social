<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [HomeController::class, 'index'])->middleware('auth')->name('feeds');
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
    Route::get('/index', [PostController::class,'index'])->middleware('auth')->name('feeds');
    Route::post('/store', [PostController::class,'store'])->middleware('auth')->name('post.store');
    Route::get('/{post}/show', [PostController::class,'show'])->middleware('auth')->name('post.show');
    Route::put('/{post}', [PostController::class,'update'])->middleware('auth')->name('post.update');
    Route::delete('/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('post.destroy');
    Route::post('/{id}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
// project routes
Route::group(['prefix'=> 'project'], function () {
    // Route::get('/index', [ProjectController::class,'index'])->middleware('auth')->name('project.index');
    Route::post('/store', [ProjectController::class,'store'])->middleware('auth')->name('project.store');
});



Route::get('/index', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');


require __DIR__.'/auth.php';
