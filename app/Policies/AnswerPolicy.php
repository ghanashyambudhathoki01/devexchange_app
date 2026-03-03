<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Answer $answer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can mark as best answer.
     */
    public function markBest(User $user, Answer $answer): bool
    {
        return $user->id === $answer->question->user_id;
    }
}
