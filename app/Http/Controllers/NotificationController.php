<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return back();
    }
}
