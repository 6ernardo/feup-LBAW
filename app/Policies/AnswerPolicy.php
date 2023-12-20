<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{
    public function create()
    {
        return Auth::check();
    }

    public function edit(User $user, Answer $answer)
    {
        return !is_null($answer) && Auth::check() && ($user->user_id === $answer->author_id ||
                $user->is_moderator ||
                $user->isAdmin());
    }

    public function delete(User $user, Answer $answer)
    {
        return  !is_null($answer) && Auth::check() && ($user->user_id === $answer->author_id ||
                $user->is_moderator ||
                $user->isAdmin());
    }
}
