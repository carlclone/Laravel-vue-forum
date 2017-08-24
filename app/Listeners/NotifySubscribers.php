<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;

class NotifySubscribers
{
    /**
     * 帖子有新回复，通知订阅了该帖子的用户.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        //Event类里的reply， 该条回复的帖子，获取该条帖子除了发布这条回复的订阅者，each 每一个都进行通知notify
        $event->reply->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);  //ThreadSubscription 中的notify,传入reply
    }
}
