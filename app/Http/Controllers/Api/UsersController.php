<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class UsersController extends Controller
{
    public function index()
    {	
 		$search = request('search');

    	return User::where('name', 'LIKE', "{$search}%")
    			->take(5)
    			->get()
    			->pluck('name')
    			->map(function($user) {
    				return ["key" => $user, "value" => $user];
    			})
    			->toJson();
    }
}
