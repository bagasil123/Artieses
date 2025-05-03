<?php

namespace App\Http\Controllers\App\artieses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class artieses extends Controller
{
    public function Search(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }

        return view('appes.searches', compact('searches'));
    }

}
