<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{

    public function create(User $user)
    {
        return Auth::check();
    }

    public function edit(User $user, Answer $answer)
    {
        return $user->user_id === $answer->author_id;
    }

    public function delete(User $user, Answer $answer)
    {
        return $user->user_id === $answer->author_id;
    }
}
