<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class LockThreadController extends Controller
{
    public function update(Thread $thread){
    	$thread->locked();
    }

    public function destroy(Thread $thread){
    	$thread->unlocked();
    }
}
