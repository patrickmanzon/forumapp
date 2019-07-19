<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Reply;

class FavoritesController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    }

    public function store(Reply $reply){
    	$reply->favorite(auth()->id());	

    	if(request()->wantsJson()) return;

    	return back();
    }

    public function destroy(Reply $reply){
    	$reply->unfavorite(auth()->id());
		if(request()->wantsJson()) return;
		return back();
    }
}
