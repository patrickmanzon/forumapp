<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

	public function store($channelId, Thread $thread){

		// if(\Gate::denies('create', new Reply)){
		// 	response("You can't reply frequently", 400);
		// }


		try {
			$this->authorize('create', new Reply);
			$this->validate(request(), [
				"body" => "required|spamfree"
			]);

			return $reply = $thread->addReply([
				"body" => request("body"),
				"user_id" => auth()->id(), 
			])->load('owner');	

		} catch (\Exception $e) {
			return response("Can't process your reply now", 400);
		}
		
	}

	public function update(Reply $reply)
	{
		try{
			$this->validate(request(), [
				"body" => "required|spamfree"
			]);

			if($reply->update(["body" => request("body")]))
			{
				return response(["message" => "Reply updated."]);
			}
		}catch(\Exception $e){
			return response("Can't make a reply right now!", 422);
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
