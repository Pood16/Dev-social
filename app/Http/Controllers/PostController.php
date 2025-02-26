<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Hashtag;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('user', 'hashtags', 'likes', 'comments')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'hashtags' => 'array',
            'hashtags.*' => 'string',
        ]);

        $imagepath = $request->file('image') ? $request->file('image')->store('posts', 'public') : null;
        $post = Post::create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'image' => $imagepath,
        ]);

        if ($request->hashtags) {
            $hashtags = collect($request->hashtags)->map(function ($tag) {
                return Hashtag::firstOrCreate(['name' => $tag])->id;
            });
            $post->hashtags()->sync($hashtags);
        }

        return redirect()->back()->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
            'hashtags' => 'array',
          
        ]);

        $imagepath = $request->file('image') ? $request->file('image')->store('posts', 'public') : $post->image;
        $post->update([
            'content' => $request->content,
            'image' => $imagepath,
        ]);

        if ($request->hashtags) {
            $hashtags = collect($request->hashtags)->map(function ($tag) {
                return Hashtag::firstOrCreate(['name' => $tag])->id;
            });
            $post->hashtags()->sync($hashtags);
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    /**
     * Like the specified post.
     */
    public function like(Post $post)
    {
        $post->likes()->create([
            'user_id' => Auth::id()
        ]);
        return redirect()->back()->with('success', 'Post liked successfully');
    }

    /**
     * Comment on the specified post.
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully');
    }

    /**
     * Filter posts by hashtag.
     */
    public function filterByHashtag($hashtag)
    {
        $posts = Hashtag::where('name', $hashtag)->firstOrFail()->posts()->paginate(10);
        return view('posts.index', compact('posts'));
    }
}
