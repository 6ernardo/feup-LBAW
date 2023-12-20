<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{

    public function edit_profile(User $user, User $user_model)
    {
        return $user->user_id === $user_model->user_id || $user->isAdmin();
    }
}
