<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    /**
     * UserAvatarController constructor.
     */
    public function __construct()
    {
    }

    /**
     * ajax保存用户头像接口.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'avatar' => ['required', 'image']
        ]);

        //保存路径
        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')  //public是disk，avatars是path，保存图片到storage/app/public/avatars，并返回路径
        ]);

        return response([], 204); //返回响应，204，无内容
    }
}
