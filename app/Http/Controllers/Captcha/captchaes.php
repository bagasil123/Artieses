<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;

class captchaes extends Controller
{
    public function hapuscaptcha(){
        if (session('regis')) {
            session()->flush();
            return redirect()->route('authes')->with(['alert' => 'Gagal registrasi!', 'form' => 'register']);
        } if (session('forget')) {
            session()->flush();
            return redirect()->route('authes')->with(['alert' => 'Gagal ganti password!', 'form' => 'forget']);
        }
    }
}