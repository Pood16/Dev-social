<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
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
                ]
            ]);
        }

        return back()->with('success', 'Comment added successfully');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully');
    }
}
