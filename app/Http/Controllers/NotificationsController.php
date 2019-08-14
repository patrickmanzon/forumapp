<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
    	return auth()->user()->unreadNotifications;
    }

    public function destroy($notification)
    {
    	return auth()->user()->notifications()->find($notification)->markAsRead();
    }
}
