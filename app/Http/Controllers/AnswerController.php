<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Services\ReputationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $answer = $question->answers()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $question->user->notify(new \App\Notifications\ActivityNotification(
            auth()->user()->name . " answered your question: " . $question->title,
            route('questions.show', $question->slug)
        ));

        return back()->with('success', 'Answer posted successfully!');
    }

    public function update(Request $request, Answer $answer)
    {
        Gate::authorize('update', $answer);

        $request->validate([
            'body' => 'required|string',
        ]);

        $answer->update($request->only('body'));

        return back()->with('success', 'Answer updated successfully!');
    }

    public function destroy(Answer $answer)
    {
        Gate::authorize('delete', $answer);

        $answer->delete();

        return back()->with('success', 'Answer deleted successfully!');
    }

    public function markBest(Answer $answer, ReputationService $reputationService)
    {
        Gate::authorize('markBest', $answer);

        // Unmark existing best answer for this question
        $answer->question->answers()->where('is_best', true)->update(['is_best' => false]);
        
        // Mark current as best
        $answer->update(['is_best' => true]);
        $answer->question->update(['is_answered' => true]);

        // Award reputation
        $reputationService->awardBestAnswer($answer->user);

        $answer->user->notify(new \App\Notifications\ActivityNotification(
            "Your answer was marked as BEST on: " . $answer->question->title,
            route('questions.show', $answer->question->slug)
        ));

        return back()->with('success', 'Answer marked as best!');
    }
}
