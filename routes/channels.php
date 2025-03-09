<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('comments-notifications.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Broadcast::channel('chat', function ($user) {
//     return Auth::check();
// });



Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Chat channel authorization
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
