<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    public function showManageUsers(){
        //policy

        $users = User::all();

        return view('pages.manageusers', ['users' => $users]);
    }
}
