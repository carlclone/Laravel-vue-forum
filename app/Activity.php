<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * 保护字段.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 用户活动的多态关联  TODO 搞清楚多态关联 .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * 获取给定用户的活动记录.
     *
     * @param  User $user
     * @param  int  $take
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function feed($user, $take = 50)
    {
        //按最新排序，预加载subject，取50条，获取到collection后，使用collection的groupBy方法分组，按创建时间Y-m-d 分组,比数据库的group by方便，扩展性好
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });

    }
}
