<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Hashtag;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->latest()->limit(10)->get();
        return view('index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store(Request $request)
    {


        // Validate the form inputs
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'hashtags' => 'nullable|string',
        ]);



        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('posts', 'public');

        }

        // Process hashtags
        $hashtags = [];
        if ($request->hashtags) {
            // Split hashtags by comma and clean them
            $hashtagArray = array_map('trim', explode(',', $request->hashtags));
            // Validate hashtag format
            foreach ($hashtagArray as $tag) {
                if (!preg_match('/^[a-zA-Z0-9_]+$/', $tag)) {
                    return back()->with(['error' => 'Hashtags can only separated by a comma (,)']);
                }
            }
            // Create or get existing hashtags
            foreach ($hashtagArray as $tag) {
                $hashtags[] = Hashtag::firstOrCreate(['name' => $tag])->id;
            }
        }

        // Create the post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'links' => $request->links,
            'hashtags' => implode(',', $hashtagArray ?? [])
        ]);


        // Attach hashtags to the post
        if (!empty($hashtags)) {
            $post->hashtags()->sync($hashtags);
        }

        return redirect()->route('feeds')->with('uccess', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        return view('post.show', compact('post'));
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
    public function update(Request $request, Post $post)
{
    if ($post->user_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'links' => 'nullable|url|max:255',
        'hashtags' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {

        if ($post->image) {
            Storage::delete($post->image);
        }
        $validated['image'] = $request->file('image')->store('posts', 'public');
    }

    $post->update($validated);

    return redirect()->route('feeds')->with('success', 'Post updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete the post image if it exists
        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->delete();

        return redirect()->route('feeds')->with('success', 'Post deleted successfully');
    }

    /**
     * Like the specified post.
     */
    // public function like(Post $post)
    // {
    //     $post->likes()->create([
    //         'user_id' => Auth::id()
    //     ]);
    //     return redirect()->back()->with('success', 'Post liked successfully');
    // }

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


    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create([
                'user_id' => Auth::id()
            ]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'likesCount' => $post->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }

    public function checkLike(Post $post)
    {
        return response()->json([
            'isLiked' => $post->likes()->where('user_id', Auth::id())->exists()
        ]);
    }

}
