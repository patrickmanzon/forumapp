<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Thread;
use App\Reply;
use App\Inspections\Spam;

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

	public function store($channelId, Thread $thread, PostRequest $form){
		return $reply = $thread->addReply([
			"body" => request("body"),
			"user_id" => auth()->id(), 
		])->load('owner');	
	}

	public function update(Reply $reply)
	{

		$this->validate(request(), [
			"body" => "required|spamfree"
		]);

		$reply->update(["body" => request("body")]);
		
		return response(["message" => "Reply updated."]);
		
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
