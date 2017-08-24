<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * 判断当前用户是否有update reply的权限.
     *
     * @param  User  $user
     * @param  Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    /**
     * 判断当前用户是否有create回复的权限.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        if (! $lastReply = $user->fresh()->lastReply) {  //如果没有上一条回复，fresh() reload model用
            return true;
        }

        return ! $lastReply->wasJustPublished();  //如果上一条回复在1分钟前发布，则不允许
    }
}
