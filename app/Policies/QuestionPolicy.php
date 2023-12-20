<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy
{
    public function create()
    {
        return Auth::check();
    }

    public function edit(User $user, Question $question)
    {
        return Auth::check() && ($user->user_id === $question->author_id ||
                $user->is_moderator ||
                $user->isAdmin());
    }

    public function delete(User $user, Question $question)
    {
        return  Auth::check() && ($user->user_id === $question->author_id ||
                $user->is_moderator ||
                $user->isAdmin());
    }

    public function select(User $user, Question $question)
    {
        return Auth::check() && ($user->user_id === $question->author_id);
    }
}
