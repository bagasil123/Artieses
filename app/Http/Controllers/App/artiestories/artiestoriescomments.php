<?php

namespace App\Http\Controllers\App\artiestories;

use App\Events\BroadcastTyping;
use App\Events\UserTyping;
use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\BalcomStories;
use Illuminate\Http\Request;
use App\Models\ComStories;
use Illuminate\Support\Facades\Broadcast;

class artiestoriescomments extends Controller
{
    public function broadcast(Request $request) {
        if (!AuthHelper::check()) {
            return redirect()->route('authes')->with('alert', 'Harus login dulu.');
        }
        $username = session('username');
        $reqplat = $request->input('comentses');
        
        broadcast(new BroadcastTyping($username, $reqplat));
        return response()->json([
            'status' => 'broadcasted',
            'username' => $username,
            'message' => $reqplat
        ]);
    }

    public function storeGG(Request $request)
    {
        if (session()->has('username')) {
            $reqplat = $request->input('comentses');
            $requscom = session('userid');
            $inputcomments = $request->input('message');
            $username = session('username');
            $comstories = ComStories::create([
                'userid' => $requscom,
                'coderies' => $reqplat,
                'commentses' => $inputcomments,
            ]);
            $message = $request->input('message');
            $improfil = session('improfil', 'default.png');
            $created_at = $comstories->created_at;
            $comstoriesid = $comstories->commentartiestoriesid;

            $now = \Carbon\Carbon::now();
            $diffInMinutes001 = $created_at->diffInMinutes($now);
            $diffInHours001 = $created_at->diffInHours($now);
            $diffInDays001 = $created_at->diffInDays($now);
            $diffInWeeks001 = $created_at->diffInWeeks($now);
            $diffInMonths001 = $created_at->diffInMonths($now);
            $diffInYears001 = $created_at->diffInYears($now);

            
            $diffInMinutes = (int) $diffInMinutes001;
            $diffInHours = (int) $diffInHours001;
            $diffInDays = (int) $diffInDays001;
            $diffInWeeks = (int) $diffInWeeks001;
            $diffInMonths = (int) $diffInMonths001;
            $diffInYears = (int) $diffInYears001;

            if ($diffInMinutes < 60) {
                $timeAgo = $diffInMinutes . ' menit yang lalu';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays < 7) {
                $timeAgo = $diffInDays . ' hari yang lalu';
            } elseif ($diffInWeeks < 4) {
                $timeAgo = $diffInWeeks . ' minggu yang lalu';
            } elseif ($diffInMonths < 12) {
                $timeAgo = $diffInMonths . ' bulan yang lalu';
            } else {
                $timeAgo = $diffInYears . ' tahun yang lalu';
            }
            broadcast(new UserTyping($username, $message, $improfil, $reqplat, $timeAgo, $comstoriesid));
            return response()->json(['status' => 'ok']);
        }
    }
    public function storeGG1(Request $request)
    {
        if (session()->has('username')) {
            $reqplat = $request->input('comentses');
            $requscom = session('userid');
            $inputcomments = $request->input('message');
            $username = session('username');
            $comstories = ComStories::create([
                'userid' => $requscom,
                'coderies' => $reqplat,
                'commentses' => $inputcomments,
            ]);
            $message = $request->input('message');
            $improfil = session('improfil', 'default.png');
            $created_at = $comstories->created_at;
            $comstoriesid = $comstories->commentartiestoriesid;

            $now = \Carbon\Carbon::now();
            $diffInMinutes001 = $created_at->diffInMinutes($now);
            $diffInHours001 = $created_at->diffInHours($now);
            $diffInDays001 = $created_at->diffInDays($now);
            $diffInWeeks001 = $created_at->diffInWeeks($now);
            $diffInMonths001 = $created_at->diffInMonths($now);
            $diffInYears001 = $created_at->diffInYears($now);

            
            $diffInMinutes = (int) $diffInMinutes001;
            $diffInHours = (int) $diffInHours001;
            $diffInDays = (int) $diffInDays001;
            $diffInWeeks = (int) $diffInWeeks001;
            $diffInMonths = (int) $diffInMonths001;
            $diffInYears = (int) $diffInYears001;

            if ($diffInMinutes < 60) {
                $timeAgo = $diffInMinutes . ' menit yang lalu';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays < 7) {
                $timeAgo = $diffInDays . ' hari yang lalu';
            } elseif ($diffInWeeks < 4) {
                $timeAgo = $diffInWeeks . ' minggu yang lalu';
            } elseif ($diffInMonths < 12) {
                $timeAgo = $diffInMonths . ' bulan yang lalu';
            } else {
                $timeAgo = $diffInYears . ' tahun yang lalu';
            }
            broadcast(new UserTyping($username, $message, $improfil, $reqplat, $timeAgo, $comstoriesid));
            return response()->json(['status' => 'ok']);
        }
    }
}
