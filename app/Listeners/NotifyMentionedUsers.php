<?php

namespace App\Listeners;

use App\Events\ThreadReceiveReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{

    /**
     * Handle the event.
     *
     * @param  ThreadReceievReply  $event
     * @return void
     */
    public function handle(ThreadReceiveReply $event)
    {
        User::whereIn("name", $event->reply->mentionedUsers())
            ->get()
            ->each(function($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
