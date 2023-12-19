<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\MailModel;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class MailController extends Controller
{
    protected function generateRandomToken() {
        
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }


    function send(Request $request) {

        $user = User::where('email', $request->email)->first();

        $token = $this->generateRandomToken();

        if($user){
            $mailData = [
                'name' => $user->name,
                'email' => $request->email,
                'token' => $token
            ];
    
            Mail::to($request->email)->send(new MailModel($mailData));

            $user->password = Hash::make($token);
            $user->save();
        }

        return redirect()->route('feed');
    }

}
