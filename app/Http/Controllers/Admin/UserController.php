<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        $user->update(['is_banned' => true]);
        return back()->with('success', 'User banned!');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);
        return back()->with('success', 'User unbanned!');
    }
}
