<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VoteService
{
    protected $reputationService;

    public function __construct(ReputationService $reputationService)
    {
        $this->reputationService = $reputationService;
    }

    public function vote(User $user, Model $voteable, int $type)
    {
        $existingVote = Vote::where('user_id', $user->id)
            ->where('voteable_id', $voteable->id)
            ->where('voteable_type', get_class($voteable))
            ->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // Remove vote
                $this->removeReputation($voteable->user, $existingVote->type, $voteable);
                $existingVote->delete();
                return null;
            } else {
                // Change vote
                $this->removeReputation($voteable->user, $existingVote->type, $voteable);
                $existingVote->update(['type' => $type]);
                $this->addReputation($voteable->user, $type, $voteable);
                return $existingVote;
            }
        }

        // New vote
        $vote = Vote::create([
            'user_id' => $user->id,
            'voteable_id' => $voteable->id,
            'voteable_type' => get_class($voteable),
            'type' => $type,
        ]);

        $this->addReputation($voteable->user, $type, $voteable);
        return $vote;
    }

    protected function addReputation(User $user, int $type, Model $voteable)
    {
        if ($type === 1) {
            $title = $voteable instanceof \App\Models\Question ? $voteable->title : Str::limit($voteable->body, 30);
            $user->notify(new \App\Notifications\ActivityNotification(
                "You received an upvote on your " . ($voteable instanceof \App\Models\Question ? 'question' : 'answer'),
                $voteable instanceof \App\Models\Question ? route('questions.show', $voteable->slug) : route('questions.show', $voteable->question->slug)
            ));

            if ($voteable instanceof \App\Models\Question) {
                $this->reputationService->awardQuestionUpvote($user);
            } else {
                $this->reputationService->awardAnswerUpvote($user);
            }
        } else {
            $this->reputationService->penalizeDownvote($user);
        }
    }

    protected function removeReputation(User $user, int $type, Model $voteable)
    {
        if ($type === 1) {
            if ($voteable instanceof \App\Models\Question) {
                $this->reputationService->revokeQuestionUpvote($user);
            } else {
                $this->reputationService->revokeAnswerUpvote($user);
            }
        } else {
            $this->reputationService->revokeDownvote($user);
        }
    }
}
