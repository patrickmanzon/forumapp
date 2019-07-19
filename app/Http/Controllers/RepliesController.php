<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class RepliesController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth')->except(["index"]);
	}

	public function index($channelId, Thread $thread){
		return $thread->replies()->paginate(5);
	}

	public function store($channelId, Thread $thread){
		$this->validate(request(), [
			"body" => "required"
		]);

		$reply = $thread->addReply([
			"body" => request("body"),
			"user_id" => auth()->id(), 
		]);

		if(request()->wantsJson()){
			return $reply->load('owner');
		}

		return back()->with('flash', 'Reply sent.');
	}

	public function update(Reply $reply, Request $request)
	{
		if($reply->update(["body" => $request->body]))
		{
			return response(["message" => "Reply updated."]);
		}

		return response(["message" => "Something went wrong"], 400);
	}

	public function destroy(Reply $reply)
	{	
		$this->authorize('update', $reply);
		$reply->delete();

		if(request()->wantsJson()){
			return ["message" => "Reply deleted."];
		}

		return back()->with('flash', 'Reply deleted.');
	}



}
