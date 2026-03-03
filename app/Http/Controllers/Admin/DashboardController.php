<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_questions' => Question::count(),
            'total_answers' => Answer::count(),
            'top_contributors' => User::orderByDesc('reputation')->take(5)->get(),
            'popular_tags' => Tag::withCount('questions')->orderByDesc('questions_count')->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
