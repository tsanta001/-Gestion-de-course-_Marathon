<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('equipe')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('equipe.home2');
        }

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.homeAdmin2');
        }

        Session::flash('error', 'Email ou mot de passe incorrect');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('equipe')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

}