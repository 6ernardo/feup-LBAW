<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{  
    public function show(User $user){
        return !is_null($user);
    }

    public function edit_profile(User $user, User $user_model)
    {
        return !is_null($user) && Auth::check() && ($user->user_id === $user_model->user_id || $user->isAdmin());
    }

    public function delete(User $user,  User $user_model) {
        return !is_null($user) && Auth::check() && ($user->user_id === $user_model->user_id || $user->isAdmin());
    }

    public function follow_tag(){
        return Auth::check();
    }

    public function unfollow_tag(){
        return Auth::check();
    }

    public function follow_question(){
        return Auth::check();
    }

    public function unfollow_question(){
        return Auth::check();
    }
    
}
