<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    /**
     * 保护字段.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获取该条订阅的用户信息.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取该条订阅的帖子信息.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * 通知订阅该帖子的用户:帖子已更新.
     *
     * @param \App\Reply $reply
     */
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));  //对当前订阅记录的相关用户进行notify，传入当前记录的帖子thread，和reply，存入数据库，数据库通知系统
    }
}
