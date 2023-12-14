<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Tag;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showDashboard(){
        $this->authorize('admin', Admin::class);

        $users = User::all();
        $tags = Tag::all();

        return view('pages.adminDashboard', ['users' => $users,
                                              'tags' => $tags]);
    }

    public function showCreateUser(){
        $this->authorize('admin', Admin::class);

        return view('pages.createUser');
    }

    public function createUser(Request $request){
        $this->authorize('admin', Admin::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($request->role === 'user'){
            $user->is_moderator = false;
        }
        else if($request->role === 'mod'){
            $user->is_moderator = true;
        }
        else {
            $user->is_moderator = true;

            $admin = new Admin();
            $admin->admin_id = $user->user_id;
            $admin->save();
        }

        $user->save();

        return redirect('user/'.$user->user_id);
        
    }

    public function search(Request $request){

        $input =$request->input('user_search_query');
        $users = User::select('users.name', 'users.user_id', 'users.email', 'users.is_moderator')
                    ->where('name', 'ilike', '%' . $input . '%')
                    ->get();

        return response()->json($users);
    }

    public function deleteUser(int $id){
        $this->authorize('admin', Admin::class);

        $user = User::find($id);

        $user->delete();

        return redirect('/admindashboard');
    }

    public function blockUser(int $id){
        $user = User::find($id);

        $this->authorize('admin', Admin::class);

        $user->is_blocked = true;
        $user->save();

        return redirect('user/'.$id);
    }

    public function unblockUser(int $id){
        $user = User::find($id);

        $this->authorize('admin', Admin::class);

        $user->is_blocked = false;
        $user->save();

        return redirect('user/'.$id);
    }

    public function changeRole(int $id, Request $request){
        $user = User::find($id);

        $this->authorize('admin', Admin::class);

        if($request->role === 'user'){
            $user->is_moderator = false;
            if($user->isAdmin()){
                $admin = Admin::find($id);
                $admin->delete();
            }
        }
        else if($request->role === 'mod'){
            $user->is_moderator = true;
            if($user->isAdmin()){
                $admin = Admin::find($id);
                $admin->delete();
            }
        }
        else if($request->role === 'admin'){
            $user->is_moderator = true;
            if(!$user->isAdmin()){
                $admin = New Admin();
                $admin->admin_id = $id;
                $admin->save();
            }
        }

        $user->save();

        return redirect('user/'.$id);
    }

}
