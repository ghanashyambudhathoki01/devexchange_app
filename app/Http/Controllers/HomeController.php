<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with(['user', 'tags'])
            ->when($request->search, function ($query, $search) {
                $query->search($search);
            })
            ->filter($request->filter)
            ->paginate(15);

        return view('home', compact('questions'));
    }
}
