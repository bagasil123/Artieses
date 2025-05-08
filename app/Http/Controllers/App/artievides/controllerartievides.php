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
        
        function generateUniqueCodevides($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, strlen($characters) - 1)];
                }
            } while (Artievides::where('codevides', $randomString)->exists());
        
            return $randomString;
        }
        $randomString = generateUniqueCodevides();
        
        $videoFile = $request->file('video');
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $videoPath = public_path(session('username') . '/artievides/' . $randomString);
        if (!file_exists($videoPath)) mkdir($videoPath, 0755, true);
        $videoFile->move($videoPath, $videoName);
        $videoPathRelatif = session('username') . '/artievides/' . $randomString . '/' . $videoName;
        
        $thumbFile = $request->file('thumbnail');
        $thumbName = time() . '_' . $thumbFile->getClientOriginalName();
        $thumbPath = public_path(session('username') . '/artithumbs/' . $randomString);
        if (!file_exists($thumbPath)) mkdir($thumbPath, 0755, true);
        $thumbFile->move($thumbPath, $thumbName);
        $thumbPathRelatif = session('username') . '/artithumbs/' . $randomString . '/' . $thumbName;

        Artievides::create([
            'userid' => session('userid'),
            'codevides' => $randomString,
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'video' => $videoPathRelatif,
            'thumbnail' => $thumbPathRelatif,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artievides mu sudah di publish!']);
    }
}
