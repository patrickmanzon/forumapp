<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class SubscribeThreadsController extends Controller
{
    public function store($channelId, Thread $thread)
    {
    	return $thread->subscribe();
    }

    public function destroy($channelId, Thread $thread)
    {
    	return $thread->unsubscribe();
    }
}
