<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilter;
class ThreadsController extends Controller
{
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
        $request->validate([
            "channel" => "required|exists:channels,id",
            "title" => "required",
            "body" => "required",
        ]);

        $thread = Thread::create([
            "channel_id" => $request->channel,
            "user_id" => auth()->id(),
            "title" => $request->title,
            "body" => $request->body,
        ]); 

        return redirect($thread->path());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {   

        return view('threads.show', [
            "thread" => $thread,
            "replies" => $thread->replies()->paginate(10)
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
        //
    }

    protected function filterThreads($channel, $filter)
    {

        $threads = Thread::filter($filter);
        if($channel->exists){
            $threads = $threads->where("channel_id", $channel->id);
        }
        return $threads->latest()->get();
    }
    
}
