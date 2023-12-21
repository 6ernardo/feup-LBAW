<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
{   

    public function show(User $user, Tag $tag){
        return !is_null($tag);
    }

    public function edit(User $user, Tag $tag){
        return !is_null($tag) && $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Tag $tag){
        return !is_null($tag) && $user->isAdmin();
    }
}
