<?php

namespace App\Http\Controllers\App\profil;

use App\Http\Controllers\Controller;
use App\Models\Users;

class profilcontroller extends Controller
{
    public function show($username)
    {
        $user = Users::where('username', $username)->firstOrFail();

        $videscontent = $user->videos()->latest()->get();
        $storiescontent = $user->stories()->latest()->get();
        $artiekelescontent = $user->artiekeles()->latest()->get();
        $subscriber = $user->subscriber()->latest()->get();
        $subscribing = $user->subscribing()->latest()->get();

        return view('appes.Artieprofil', compact('user', 'videscontent', 'storiescontent', 'artiekelescontent', 'subscriber', 'subscribing'));
    }
}
