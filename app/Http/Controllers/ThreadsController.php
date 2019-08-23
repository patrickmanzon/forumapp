<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilter;
use App\Inspections\Spam;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadsFilter $filter)
    {

        $threads = $this->filterThreads($channel, $filter);
      
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('threads.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate(request(),[
            "channel" => "required|exists:channels,id",
            "title" => "required|spamfree",
            "body" => "required|spamfree",
        ]);

        $thread = Thread::create([
            "channel_id" => $request->channel,
            "user_id" => auth()->id(),
            "title" => $request->title,
            "body" => $request->body,
        ]); 

        return redirect($thread->path())->with('flash', 'Thread created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {   

        if(auth()->check()){
            auth()->user()->read($thread);
        }

        return view('threads.show', [
            "thread" => $thread,
            "replies" => $thread->replies()->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {   

        $this->authorize('update', $thread);
        $thread->delete();
        return redirect('threads');
    }

    protected function filterThreads($channel, $filter)
    {

        $threads = Thread::filter($filter);
        if($channel->exists){
            $threads = $threads->where("channel_id", $channel->id);
        }
        return $threads->latest()->paginate(10);
    } 
}
