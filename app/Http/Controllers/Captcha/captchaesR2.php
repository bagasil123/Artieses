<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\File;

class captchaesR2 extends Controller
{
    public function captcha1(Request $request){
        $kodeinput = $request->input('kodeinputes');
        $kodecapt = session('captcha_verified');
        if (session('regis')){
            if ($kodeinput === $kodecapt){
                $defaultImage = "defaultuser.png";
                $source = public_path($defaultImage);
                $destinationDir = public_path(session('username') . '/profil');
                $destination = $destinationDir . '/' . $defaultImage;
                if (!File::exists($destinationDir)) {
                    File::makeDirectory($destinationDir, 0755, true);
                }
                File::copy($source, $destination);
                Users::create([
                    'username' => session('username'),
                    'nameuse' => session('nameuse'),
                    'email' => session('email'),
                    'password' => bcrypt(session('password')),
                    'improfil' => session('improfil'),
                ]);
                session()->flush();
                return redirect()->route('authes')->with(['alert' => 'Yey akun mu sudah jadi!', 'form' => 'login']);
            } else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            }
        } if (session('forget')){
            if ($kodeinput === $kodecapt){
                return redirect()->route('authes')->with(['alert' => 'Ubah password kamu!', 'form' => 'forget1']);
            }
           else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            } 
        } 
    }
}
