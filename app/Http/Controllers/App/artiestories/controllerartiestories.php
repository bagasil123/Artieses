<?php

namespace App\Http\Controllers\App\artiestories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artiestories;
use App\Models\ComStories;
use App\Models\Rcm1Story;
use App\Models\Rcm2Story;
use App\Models\ReactStories;

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
    public function store(Request $request)
{
    if (!session('isLoggedIn')) {
        return response()->json([
            'logged_in' => false,
            'redirect' => route('authes'),
            'alert' => 'Harus login dulu!',
            'form' => 'login'
        ]);
    }

    $validated = $request->validate([
        'reaksi' => 'required|string',
        'artiestoriesid' => 'required|integer|exists:artiestories,artiestoriesid',
    ]);
    $existingReaction = ReactStories::where('userid', session('userid'))
                                     ->where('artiestoriesid', $validated['artiestoriesid'])
                                     ->first();

    if ($existingReaction) {
        $existingReaction->reaksi = $validated['reaksi'];
        $existingReaction->save();
        $message = 'Reaksi berhasil diperbarui';
        $created = $existingReaction;
    } else {
        $created = ReactStories::create([
            'userid' => session('userid'),
            'artiestoriesid' => $validated['artiestoriesid'],
            'reaksi' => $validated['reaksi'],
        ]);
        $message = 'Reaksi berhasil ditambahkan';
    }

    return response()->json([
        'logged_in' => true,
        'success' => true,
        'message' => $message,
        'data' => $created,
        'csrf' => csrf_token()
    ]);
}
public function storeGG(Request $request)
{
    if (!session('isLoggedIn')) {
        return response()->json([
            'logged_in' => false,
            'redirect' => route('authes'),
            'alert' => 'Harus login dulu!',
            'form' => 'login'
        ]);
    }

    $reqplat = $request->input('commentses');
    $requscom = session('userid');
    $inputcomments = $request->input('inputcommentnya');

    ComStories::create([
        'userid' => $requscom,
        'artiestoriesid' => $reqplat,
        'commentses' => $inputcomments,
    ]);

    return redirect()->to('/artieses#commentarist-' . $reqplat)
                     ->with('open_commentarist', $reqplat);
}


    public function store2(Request $request)
    {
        if (!session('isLoggedIn')) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $validated = $request->validate([
            'reaksi' => 'required|string',
            'commentartiestoriesid' => 'required|integer|exists:commentartiestories,commentartiestoriesid',
        ]);

        $existingReaction = Rcm1Story::where('userid', session('userid'))->where('commentartiestoriesid', $validated['commentartiestoriesid'])->first();
        if ($existingReaction) {
            $existingReaction->reaksi = $validated['reaksi'];
            $existingReaction->save();
            $message = 'Reaksi berhasil diperbarui';
            $created = $existingReaction;
        } else {
            $created = Rcm1Story::create([
                'userid' => session('userid'),
                'commentartiestoriesid' => $validated['commentartiestoriesid'],
                'reaksi' => $validated['reaksi'],
            ]);
            $message = 'Reaksi berhasil ditambahkan';
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $created,
            'csrf' => csrf_token()
        ]);
    }
    
    public function store3(Request $request)
    {
        if (!session('isLoggedIn')) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $validated = $request->validate([
            'reaksi' => 'required|string',
            'balcomstoriesid' => 'required|integer|exists:balcomstories,balcomstoriesid',
        ]);

        $existingReaction = Rcm2Story::where('userid', session('userid'))->where('balcomstoriesid', $validated['balcomstoriesid'])->first();
        if ($existingReaction) {
            $existingReaction->reaksi = $validated['reaksi'];
            $existingReaction->save();
            $message = 'Reaksi berhasil diperbarui';
            $created = $existingReaction;
        } else {
            $created = Rcm2Story::create([
                'userid' => session('userid'),
                'balcomstoriesid' => $validated['balcomstoriesid'],
                'reaksi' => $validated['reaksi'],
            ]);
            $message = 'Reaksi berhasil ditambahkan';
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $created,
            'csrf' => csrf_token()
        ]);
    }
}
