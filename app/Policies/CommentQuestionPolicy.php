<?php

namespace App\Policies;

use App\Models\CommentQuestion;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentQuestionPolicy
{
    public function create(User $user)
    {
        return Auth::check();
    }

    public function edit(User $user, CommentQuestion $comment)
    {
        return $user->user_id === $comment->author_id;
    }

    public function delete(User $user, CommentQuestion $comment)
    {
        return $user->user_id === $comment->author_id ||
                $user->is_moderator ||
                $user->isAdmin();
    }
}
