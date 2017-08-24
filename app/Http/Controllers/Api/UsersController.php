<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    /**
     * 获取@后自动完成用户名.
     *
     * @return mixed
     */
    public function index()
    {
        $search = request('name');

        //@功能的数据接口，取5个，只取name列
        return User::where('name', 'LIKE', "%$search%")
            ->take(5)
            ->pluck('name');
    }
}
