<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    
    public function login() {

        return view('login');
    }

    public function logon(Request $request) {

        if(empty($request->email) || empty($request->password)) {
            return redirect()->back()->with('error', 'E-mail ou senha vazios!');
        }

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            return redirect()->route('app');
        } else {
            return redirect()->back()->with('error', 'Credenciais inválidas!');
        }

    }

    public function logout() {

        Auth::logout();
        return redirect()->route('login');
    }

}
