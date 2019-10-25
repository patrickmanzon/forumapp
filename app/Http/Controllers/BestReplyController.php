<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class BestReplyController extends Controller
{
    public function store(Reply $reply){
    	$reply->markBest();
    }
}
