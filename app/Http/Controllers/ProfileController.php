<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller{

    public function show(){
        $user = Auth::user();
        return view("profile.profile", compact("user"));
    }

    // update the profile section
    public function showEditProfile(){
        $user = Auth::user();
        return view("profile.edit", compact("user"));
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

    public function edit(Request $request): View{
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // add new skills(Languages) To profile
    public function addSkills(Request $request){

        $request->validate([
            'skill' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $currentSkills = $user->language ?? '';


        if ($currentSkills) {
            $skills = explode(',', $currentSkills);
            $skills[] = $request->skill;
            $newSkills = implode(',', $skills);
        } else {
            $newSkills = $request->skill;
        }

        $user->language = $newSkills;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Skill added successfully',
            'skills' => explode(',', $newSkills),
        ]);
    }



    public function showUserProfile($userId){

        $user = User::findOrFail($userId);
        $posts = $user->posts()->with(['user', 'likes', 'comments.user'])->latest()->paginate(10);


        $isOwnProfile = Auth::id() === $user->id;

        return view("profile.user-profile", compact("user", "posts", "isOwnProfile"));
    }



}
