<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;   //用户可以被notify，这里要看官方文档

    /**
     * 可填充的字段.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * 隐藏的字段.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * 路由模型绑定时候匹配的字段.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * 获取该用户的所有帖子，按最新排序.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * 获取用户的所有回复，按最新排序.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * 获取用户的所有活动.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * 将特定帖子标为该用户已读,存入缓存中.
     *
     * @param Thread $thread
     */
    public function read($thread)  //将文章标为已读，使用缓存
    {
        cache()->forever(   //helper method ， 永久缓存
            $this->visitedThreadCacheKey($thread), //已阅读过的帖子key生成
            Carbon::now()  //设为当前时间
        );
    }

    /**
     * 将用户的头像路径转换成链接.
     *
     * @param  string $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ?: 'images/avatars/default.png');
    }

    /**
     * 生成用户已读帖子的key.
     *
     * @param  Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);  //key组合
    }
}
