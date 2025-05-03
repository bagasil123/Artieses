<?php

namespace App\Http\Controllers\App\artievides;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artievides;

class controllerartievides extends Controller
{
    public function uploadFile(Request $request)
    {
    
        if (!session('isLoggedIn')) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        $judul = $request->input('judul');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv,mkv,flv,mpeg,3gp',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);
        
        $videoFile = $request->file('video');
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $videoPath = public_path(session('username') . '/artievides');
        if (!file_exists($videoPath)) mkdir($videoPath, 0755, true);
        $videoFile->move($videoPath, $videoName);
        $videoPathRelatif = session('username') . '/artievides/' . $videoName;
        
        $thumbFile = $request->file('thumbnail');
        $thumbName = time() . '_' . $thumbFile->getClientOriginalName();
        $thumbPath = public_path(session('username') . '/artithumbs');
        if (!file_exists($thumbPath)) mkdir($thumbPath, 0755, true);
        $thumbFile->move($thumbPath, $thumbName);
        $thumbPathRelatif = session('username') . '/artithumbs/' . $thumbName;
        
        Artievides::create([
            'userid' => session('userid'),
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'video' => $videoPathRelatif,
            'thumbnail' => $thumbPathRelatif,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artievides mu sudah di publish!']);
    }
}
