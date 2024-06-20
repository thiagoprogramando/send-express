<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller {
    
    public function register($code = null) {

        return view('register', ['code' => $code]);
    }

    public function registrer(Request $request) {

        $user = User::where('cpfcnpj', $request->cpfcnpj)->orWhere('email', $request->email)->exists();
        if($user) {
            return redirect()->back()->with('error', 'Já existe um usuário com os dados informados!'); 
        }

        $user           = new User();
        $user->name     = $request->name;
        $user->cpfcnpj  = $request->cpfcnpj;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);

        $credentials = $request->only(['email', 'password']);
        if($user->save() && Auth::attempt($credentials)) {
            
            return redirect()->route('app');
        } else {
            return redirect()->route('login')->with('success', 'Bem-vindo(a)! Faça Login.');
        }

    }
}
