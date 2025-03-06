<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchHashtags(Request $request){



        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->route('feeds');
        }


        $searchHashtag = trim($query, '#');


        $posts = Post::where('hashtags', 'like', "%$searchHashtag%")
                     ->with(['user', 'likes', 'comments'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('search.results', [
            'posts' => $posts,
            'query' => $query,
        ]);
    }
}
