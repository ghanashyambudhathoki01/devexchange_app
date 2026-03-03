<?php

namespace App\Services;

use App\Models\User;

class ReputationService
{
    const QUESTION_UPVOTE = 5;
    const ANSWER_UPVOTE = 10;
    const BEST_ANSWER = 15;
    const DOWNVOTE = -2;

    public function awardQuestionUpvote(User $user)
    {
        $user->increment('reputation', self::QUESTION_UPVOTE);
    }

    public function awardAnswerUpvote(User $user)
    {
        $user->increment('reputation', self::ANSWER_UPVOTE);
    }

    public function awardBestAnswer(User $user)
    {
        $user->increment('reputation', self::BEST_ANSWER);
    }

    public function penalizeDownvote(User $user)
    {
        $user->increment('reputation', self::DOWNVOTE);
    }

    public function revokeQuestionUpvote(User $user)
    {
        $user->decrement('reputation', self::QUESTION_UPVOTE);
    }

    public function revokeAnswerUpvote(User $user)
    {
        $user->decrement('reputation', self::ANSWER_UPVOTE);
    }

    public function revokeBestAnswer(User $user)
    {
        $user->decrement('reputation', self::BEST_ANSWER);
    }

    public function revokeDownvote(User $user)
    {
        $user->decrement('reputation', self::DOWNVOTE);
    }
}
