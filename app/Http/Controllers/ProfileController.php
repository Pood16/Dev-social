<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function show(){
        $user = Auth::user();
        return view("profile.profile", compact("user"));
    }
    // update the profile section
    public function showEditProfile(){
        $user = User::where("id",Auth::user()->id)->first();
        return view("profile.complete", compact("user"));
    }
    // submit the profile updates
    public function updateProfile(Request $request){
        $user = User::where("id",Auth::user()->id)->first();
        $request->validate([
            "name"=> "required",
            'bio' => 'required',
            'language' => 'required',
            'github_url' => 'required',
        ]);
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->language = $request->language;
        $user->github_url = $request->github_url;
        $user->save();
        return  Redirect::route('profile')->with("success", "Profile updated successfully");
    }

    // cover and profile image update
    public function updateCover(Request $request){
        // $user = User::where("id",Auth::user()->id)->first();
        $imagepath = $request->file('cover_image') ? $request->file('cover_image')->store('profile-covers', 'public') : null;
        $request->user()->cover_picture = $imagepath;
        $request->user()->save();
        return  Redirect::route('profile');
    }
    public function updateProfileImage(Request $request){
        $user = User::where("id",Auth::user()->id)->first();
        $imagepath = $request->file('profile_image') ? $request->file('profile_image')->store('profile-images', 'public') : null;
        $user->profile_picture = $imagepath;
        $user->save();
        return  Redirect::route('profile');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }



}
