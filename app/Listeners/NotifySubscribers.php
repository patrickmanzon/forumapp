<?php

namespace App\Listeners;

use App\Events\ThreadReceiveReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class NotifySubscribers
{

    /**
     * Handle the event.
     *
     * @param  ThreadReceievReply  $event
     * @return void
     */
    public function handle(ThreadReceiveReply $event)
    {
        $event->reply->thread->subscriptions->filter( function ($subscription) use ($event) {
            return $subscription->user_id != $event->reply->user_id;
        })->each->notify($event->reply);
    }
}
