<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(){
        return view('pages.authentication.login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = array(
            'email' => $request['email'],
            'password' => $request['password'],
        );

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 1) {
                return redirect()->route('dashboard');
            } else {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact support for assistance.');
            }
        } else {
            return back()->with('error', 'The email or password you entered is incorrect. Please try again.');
        }

    }

    public function logout() {
        Auth::guard('web')->logout();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }
}
