<?php

namespace App\Http\Controllers\App\artiestories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artiestories;

class controllerartiestories extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        $judul = $request->input('caption');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'file' => 'required|file|mimes:png, jpg, jpeg, gif'
        ]);
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path(implode('/', [session('username'), 'artiestories']));
        $file->move($destinationPath, $filename);
        $filepath = implode('/', [session('username'), 'artiestories', $filename]);
        
        Artiestories::create([
            'userid' => session('userid'),
            'caption' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'konten' => $filepath,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artiestories mu sudah di publish!']);
    }
}
