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
        return view('pages.editUser', ['user' => $user]);
    }

    public function editProfile(int $id, Request $request){
        $user = User::find($id);

        $this->authorize('edit_profile', $user, Auth::user());

        if($request->name){
            $request->validate([
                'name' => 'string|max:255',
            ]);
            $user->name = $request->input('name');
        }

        if($request->email){
            $request->validate([
                'email' => 'email|unique:users,email|max:255'
            ]);
            $user->email = $request->input('email');
        }

        if($request->password){
            $request->validate([
                'password' => 'min:8|max:255|confirmed'
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect('user/'.$id);
        
    }

    public function showQuestions(int $id){
        $user = User::find($id);
        return view('pages.userQuestion', ['userQuestions' => $user->questions]);
    }

    public function showAnswers(int $id){
        $user = User::find($id);
        return view('pages.userAnswers', ['data' => $user->answers]);
    }
}
