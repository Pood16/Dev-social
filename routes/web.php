<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

require __DIR__.'/auth.php';

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::middleware(['auth'])->group(function () {
    // Home/Feed routes
    Route::get('/index', [HomeController::class, 'index'])->name('feeds');
    // Route::get('/chat', [HomeController::class, 'chat'])->name('chat');

    // Profile routes
    Route::group(['prefix'=> 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/update', [ProfileController::class, 'showEditProfile'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/cover', [ProfileController::class, 'updateCover'])->name('profile.cover');
        Route::post('/self', [ProfileController::class, 'updateProfileImage'])->name('profile.self');
    });

    // Post routes
    Route::group(['prefix'=> 'post'], function () {
        Route::get('/index', [PostController::class, 'index'])->name('feeds');
        Route::post('/store', [PostController::class, 'store'])->name('post.store');
        Route::get('/{post}/show', [PostController::class, 'show'])->name('post.show');
        Route::put('/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::post('/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
        Route::get('/{post}/check-like', [PostController::class, 'checkLike'])->name('posts.checkLike');

        // Comment routes
        Route::post('/{id}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

    // Project routes
    Route::group(['prefix'=> 'project'], function () {
        Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    });

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('index.notifications');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');

    // Connection routes
    Route::controller(ConnectionController::class)->group(function () {
        Route::post('/post/connections/send/{user}', 'sendRequest')->name('request.send');
        Route::get('/post/connections/status/{user}', 'checkConnectionStatus')->name('request.status');
        Route::get('/connections/accepted', 'getAcceptedConnections')->name('connections.accepted');
        Route::get('/connections', 'getAllConnections')->name('connections');
        Route::post('/connections/accept/{connection}', 'acceptRequest')->name('connections.accept');
        Route::post('/connections/reject/{connection}', 'rejectRequest')->name('connections.reject');
        Route::delete('/connections/destroy/{connection}', 'removeConnection')->name('connections.destroy');
    });

    // Search routes
    Route::get('/search/hashtags', [SearchController::class, 'searchHashtags'])->name('search.hashtags');
});

// Development routes
Route::view('pusher1', 'pusher1');
Route::view('pusher2', 'pusher2');

// Route::middleware('auth')->group(function () {
//     Route::get('/messages', [ChatController::class, 'fetchMessages']);
//     Route::post('/send-message', [ChatController::class, 'sendMessage']);
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/conversations', [ChatController::class, 'getConversations'])->name('chat.conversations');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/messages', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread', [ChatController::class, 'getUnreadCount'])->name('chat.unread');
    Route::post('/chat/messages/{messageId}/read', [ChatController::class, 'markAsRead'])->name('chat.read');
});






