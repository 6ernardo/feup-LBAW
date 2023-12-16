<?php

namespace App\Policies;

use App\Models\CommentAnswer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentAnswerPolicy
{
    public function create(User $user)
    {
        return Auth::check();
    }

    public function edit(User $user, CommentAnswer $comment)
    {
        return $user->user_id === $comment->author_id;
    }

    public function delete(User $user, CommentAnswer $comment)
    {
        return $user->user_id === $comment->author_id ||
                $user->is_moderator ||
                $user->isAdmin();
    }
}
