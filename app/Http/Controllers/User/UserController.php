<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    
    public function profile() {

        return view('app.User.profile');
    }

    public function updateUser(Request $request) {

        $user = User::find($request->id);

        if(!empty($request->name)) {
            $data['name'] = $request->name;
        }

        if(!empty($request->name)) {
            $data['name'] = $request->name;
        }

        if(!empty($request->email)) {
            $data['email'] = $request->email;
        }

        if(!empty($request->date_of_birth)) {
            $data['date_of_birth'] = $request->date_of_birth;
        }

        if(!empty($request->address)) {
            $data['address'] = $request->address;
        }

        if(!empty($request->phone)) {
            $data['phone'] = $request->phone;
        }

        if(!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
    
            $data['profile_picture'] = $path;
        }

        if($user && $user->update($data)) {
            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
        }

        return redirect()->back()->with('error', 'Não foi possível atualizar os dados, tente novamente mais tarde!');
    }

}
