<?php
namespace App\Http\Controllers\App\profil;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class profilcontroller extends Controller
{
    public function show(Request $request, $username)
    {
        $reqplat = $request->query('GetContent');
        $user = Users::where('username', $username)->firstOrFail();
        $videscontent = $user->videos()->orderByDesc('created_at')->get();
        $storiescontent = $user->stories()->orderByDesc('created_at')->get();
        $articlescontent = $user->artiekeles()->orderByDesc('created_at')->get();
        $subscriber = $user->subscriber()->latest()->get();
        $subscribing = $user->subscribing()->latest()->get();
        return view('appes.Artieprofil', [
        'user' => $user,
        'stories' => $storiescontent,
        'open_commentarist' => $reqplat,
        ], compact('user', 'videscontent', 'storiescontent', 'articlescontent', 'subscriber', 'subscribing'));
    }
    public function updateUsername(Request $request, $username)
    {
        $request->validate([
            'username' => 'required|string|alpha_dash|unique:users,username'
        ]);

        $user = Users::where('username', $username)->firstOrFail();

        $lastUpdated = $user->editusername;
        if ($lastUpdated && now()->diffInDays($lastUpdated) < 7) {
            return response()->json([
                'success' => false,
                'message' => 'Username hanya bisa diubah setiap 7 hari.'
            ]);
        }

        if (Users::where('username', $request->username)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Username sudah digunakan.'
            ]);
        }

        $user->username = $request->username;
        $user->editusername = now();
        $user->save();
        session(['username' => $request->username]);
        return response()->json(['success' => true]);
    }
    public function updatenameuse(Request $request, $username)
    {
        $request->validate([
            'nameuse' => 'required|string|max:255'
        ]);
        $user = Users::where('username', $username)->firstOrFail();
        $user->nameuse = $request->nameuse;
        $user->save();
        session(['nameuse' => $request->nameuse]);
        return response()->json(['success' => true]);
    }
    public function updateBio(Request $request, $username)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
        ]);
        $user = Users::where('username', $username)->firstOrFail();
        $user->bio = $request->bio;
        $user->save();
        session(['bio' => $request->bio]);
        return response()->json(['success' => true]);
    }
}
