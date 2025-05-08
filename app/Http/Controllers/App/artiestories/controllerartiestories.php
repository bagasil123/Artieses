<?php

namespace App\Http\Controllers\App\artiestories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artiestories;
use App\Models\ArtiestoriesIMG;
use getID3;

class controllerartiestories extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        function generateUniqueCodestories($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, strlen($characters) - 1)];
                }
            } while (Artiestories::where('coderies', $randomString)->exists());
        
            return $randomString;
        }
        $randomString = generateUniqueCodestories();
        $judul = $request->input('caption');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'file.*' => 'required|mimes:mp4,mov,avi,jpeg,jpg,png,gif',
        ]);
        $files = $request->file('file');
        $baseFolder = session('username') . '/artiestories/' . $randomString;
        $destinationPath = public_path($baseFolder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        if (!$files || count($files) === 0) {
            dd($request->all(), $request->file('file'));
            return redirect()->route('artieses')->with(['alert' => 'Tidak ada item yang diunggah!']);
        }$post = Artiestories::create([
            'userid' => session('userid'),
            'coderies' => $randomString,
            'caption' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
        ]);
        
        $getID3 = new getID3;
        
        foreach ($files as $file) {
            $info = $getID3->analyze($file->getPathname());
            $duration = $info['playtime_seconds'] ?? 0;
            if ($duration > 60) {
                return back()->withErrors(['alert' => 'Durasi video tidak boleh lebih dari 60 detik!']);
            }
        }
        foreach ($files as $index => $file) {
            $extension = $file->getClientOriginalExtension();
            $newFilename = session('username') . '_' . date('Ymd_His') . '_' . $index . '.' . $extension;
            
            $file->move($destinationPath, $newFilename);
            $filepath = $baseFolder . '/' . $newFilename;
        
            ArtiestoriesIMG::create([
                'artiestoriesid' => $post->artiestoriesid,
                'konten' => $filepath,
            ]);
        }
        
        return redirect()->route('artieses')->with(['alert' => 'Artiestories mu sudah di publish!']);
    }
}
