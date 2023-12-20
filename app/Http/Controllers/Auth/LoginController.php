<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/feed');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/feed');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 

    public function showForgotPassword(){
        return view('auth.forgotPassword');
    }

    public function showResetPassword(string $token){
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function handleResetPassword(Request $request){

        $user = User::where('email', $request->email)->first();

        if(Hash::check($request->token, $user->password)){
            $request->validate([
                'password' => 'required|min:8|max:255|confirmed'
            ]);

            $user->password = Hash::make($request->password);

            $user->save();

            return redirect()->route('feed')
            ->withSuccess('You have successfully recovered your password!');
        }

        return redirect()->route('login')->with('invalid_token', "Invalid token.");
    }


}
