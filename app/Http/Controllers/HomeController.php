<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user','comments', 'likes'])
            ->latest()
            ->paginate(10);
            dd($posts);
        return view('index', compact('posts'));

    }

    public function chat(){
        $connections = Connection::where(function($query) {
            $query->where('sender_id', Auth::id())
                ->where('status', 'accepted');
        })->orWhere(function($query) {
            $query->where('receiver_id', Auth::id())
                ->where('status', 'accepted');
        })->with(['sender', 'receiver'])->get();
        return view('chat', compact('connections'));
    }

}
