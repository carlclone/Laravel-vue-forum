<?php

namespace App\Http\Controllers;

use App\Reply;

//使用了restful的风格进行点赞和取消点赞， post /reply/{reply}/favorite   delete /favorite
class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 保存点赞记录.
     *
     * @param  Reply $reply
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
    }

    /**
     * 删除点赞记录.
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
