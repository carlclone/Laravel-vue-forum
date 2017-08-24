<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']); //排除index
    }

    /**
     * 获取帖子相关回复.
     *
     * @param int    $channelId
     * @param Thread $thread
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * 保存回复.
     *
     * @param  integer           $channelId
     * @param  Thread            $thread
     * @param  CreatePostRequest $form
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        //添加回复
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');   //$reply->load('owner'); 延迟预加载
    }

    /**
     * 更新回复.
     *
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);  //验证当前用户是否有该回复的update权限

        $this->validate(request(), ['body' => 'required|spamfree']);  //TODO spamfree类 自定义字段过滤

        $reply->update(request(['body']));
    }

    /**
     * 删除回复.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);  //TODO 授权验证的helper method

        $reply->delete();

        if (request()->expectsJson()) {   //如果请求是json
            return response(['status' => 'Reply deleted']);  //返回
        }

        return back();
    }
}
