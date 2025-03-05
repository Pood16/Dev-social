<?php

namespace App\Http\Controllers;

use App\Events\PostCommented;
use App\Events\TestNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id )
    {

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
        $post = Post::findOrFail($id);

        $comment = $post->comments()->create([
            'comment' => $validated['comment'],
            'user_id' => Auth::id(),
        ]);
        $post->user->notify(new CommentNotification($post));
        // event(new PostCommented([
        //     'author' => $post->comments->last()->user->name,
        //     'message' => 'commented on your post',
        //     'content' => $post->title,
        // ]));

        $postOwner = $post->user->id;

        // Fire event to notify the post owner
        // event(new PostCommented($comment));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => [
                        'name' => Auth::user()->name,
                        'profile_picture' => Auth::user()->profile_picture
                    ],
                    'post_owner' => $postOwner
                ]
            ]);
        }

        return redirect()->back();
    }

    public function destroy(Comment $comment)
{
    if ($comment->user_id !== Auth::id()) {
        abort(403);
    }

    $comment->delete();

    if (request()->expectsJson()) {
        return response()->json([
            'success' => true,
        ]);
    }

    return redirect()->back();
}
}
