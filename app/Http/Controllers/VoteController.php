<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, VoteService $voteService)
    {
        $request->validate([
            'voteable_id' => 'required|integer',
            'voteable_type' => 'required|string|in:question,answer',
            'type' => 'required|integer|in:1,-1',
        ]);

        $modelClass = $request->voteable_type === 'question' ? Question::class : Answer::class;
        $voteable = $modelClass::findOrFail($request->voteable_id);

        $voteService->vote(auth()->user(), $voteable, $request->type);

        return back()->with('success', 'Vote recorded!');
    }
}
