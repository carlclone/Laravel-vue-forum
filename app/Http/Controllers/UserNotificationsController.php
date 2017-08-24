<?php

namespace App\Http\Controllers;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 获取当前用户未读通知.
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;   //获取用户未读通知
    }

    /**
     * 将特定通知标记为已读.
     *
     * @param \App\User $user
     * @param int       $notificationId
     */
    public function destroy($user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();   //获取特定通知并标为已读
    }
}
