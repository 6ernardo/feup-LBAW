<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(int $id){
        $user = User::find($id);

        return view('pages.user', ['user' => $user]);
    }

    public function showEditForm(int $id){
        $user = User::find($id);

        $this->authorize('edit_profile', $user, Auth::user());
        return view('pages.editUser', ['user' => $user,
                                        'old' => ['name' => $user->name,
                                                    'email' => $user->email]]);
    }
}
