<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class UserAvatarController extends Controller
{
    public function store(User $user, Request $request)
    {

    	$request->validate([
    		"avatar" => "image|required"
    	]);

    	if($user->profile_image)
    	{
    		unlink(str_replace(url('/'), public_path(), $user->profile_image));
    	}

    	auth()->user()->update([
    		"profile_image" => $request->file('avatar')->store('avatars', 'public')
    	]);

    	return back();

    }
}
