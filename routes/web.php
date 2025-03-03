<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
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
    Route::post('/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::get('/{post}/check-like', [PostController::class, 'checkLike'])->name('posts.checkLike');
});
// project routes
Route::group(['prefix'=> 'project'], function () {
    // Route::get('/index', [ProjectController::class,'index'])->middleware('auth')->name('project.index');
    Route::post('/store', [ProjectController::class,'store'])->middleware('auth')->name('project.store');
});


// notifications routes
Route::get('/mark-as-read', [PostController::class,'markAsRead'])->name('mark-as-read');
Route::get('/test', [HomeController::class,'index'])->name('homeTest');



Route::get('/index', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

// connection routes
Route::controller(ConnectionController::class)->middleware('auth')->group(function () {
    Route::post('/post/connections/send/{user}', 'sendRequest')->name('request.send');
    Route::get('/post/connections/status/{user}', 'checkConnectionStatus')->name('request.status');
    Route::get('/connections/accepted', 'getAcceptedConnections')->name('connections.accepted');
    Route::get('/connections', 'getAllConnections')->name('connections');
    Route::post('/connections/accept/{connection}', 'acceptRequest')->name('connections.accept');
    Route::post('/connections/reject/{connection}', 'rejectRequest')->name('connections.reject');
    Route::delete('/connections/destroy/{connection}', 'removeConnection')->name('connections.destroy');
});



require __DIR__.'/auth.php';
