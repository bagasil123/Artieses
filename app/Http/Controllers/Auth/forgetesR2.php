<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class forgetesR2 extends Controller
{
    public function forget1(Request $request)
    {
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $user = session('usernameemail');
        
        $existingUser = Users::where('username', $user)->orwhere('email', $user)->first();
        if ($password !== $password_confirmation) {
            return redirect()->route('authes')->with(['alert' => 'Password dan Konfirmasi Password tidak cocok!', 'form' => 'forget1']);
        } if ($existingUser){
            Users::where('email', $existingUser->email)->update(['password' => bcrypt($password)]);
            session()->flush();
            return redirect()->route('authes')->with(['alert' => 'Password kamu sudah diganti!', 'form' => 'login']);
        }
    }
}
