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

        if ($request->hasFile('profilePicture')) {
            $request->validate([
                'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $file = $request->file('profilePicture');
            $path = $file->storeAs('profile_pictures', 'profile_' . $user->user_id . '.' . $file->getClientOriginalExtension(), 'public');

            $user->profile_picture = $path;
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

    public function delete(int $id){
        $user = User::find($id);

        //policy

        $user->delete();

        return redirect('/');
    }
}
