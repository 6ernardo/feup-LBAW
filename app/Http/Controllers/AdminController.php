<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AdminController extends Controller
{
    public function showManageUsers(){
        //policy

        $users = User::all();

        return view('pages.manageusers', ['users' => $users]);
    }

    public function showCreateUser(){
        //policy

        return view('pages.createUser');
    }

    public function createUser(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'moderator' => $request->role
        ]);

        return redirect('user/'.$user->user_id);
        
    }

    public function search(Request $request){
        //policy

        $input =$request->input('user_search_query');
        $users = User::select('users.name', 'users.user_id', 'users.email', 'users.moderator')
                    ->where('name', 'ilike', '%' . $input . '%')
                    ->get();

        return response()->json($users);
    }
}
