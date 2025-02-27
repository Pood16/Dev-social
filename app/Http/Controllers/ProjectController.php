<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'url|max:255',
        ]);
        // dd($validated);

        // Create the project
        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'lien_git' => $validated['url'],
            'user_id' => Auth::id()
        ]);

        // Redirect back with success message
        return redirect()->route('profile')->with('success', 'Project added successfully');
    }
}
