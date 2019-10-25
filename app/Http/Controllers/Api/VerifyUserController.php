<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class VerifyUserController extends Controller
{
    //

    public function index(){

    	try {
    		$user = User::where('confirmation_token', request('token'))
						->firstOrFail()
						->verified();

			return redirect('/threads')->with('flash', 'You are now a verified user.');
   	
    	} catch (Exception $e) {
    		return redirect('/threads')->with('flash', 'Invalid Token');
    	}
		
    }
}
