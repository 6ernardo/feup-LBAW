<?php

namespace App\Policies;

use App\Models\CommentQuestion;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentQuestionPolicy
{
    public function create()
    {
        return Auth::check();
    }

    public function edit(User $user, CommentQuestion $comment)
    {
        return Auth::check() && !is_null($comment) && $user->user_id === $comment->author_id;
    }

    public function delete(User $user, CommentQuestion $comment)
    {
        return Auth::check() && !is_null($comment) && ($user->user_id === $comment->author_id ||
                $user->is_moderator ||
                $user->isAdmin());
    }
}
