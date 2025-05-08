<?php

namespace App\Http\Controllers\App\artiestories;

use App\Http\Controllers\Controller;
use App\Models\BalcomStories;
use Illuminate\Http\Request;
use App\Models\ComStories;

class artiestoriescomments extends Controller
{
    public function storeGG(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('authes')->with('alert', 'Harus login dulu.');
        }

        $reqplat = $request->input('commentses');
        $reqplat1 = $request->input('commentsesarah');
        $requscom = session('userid');
        $inputcomments = $request->input('inputcommentnya');

        ComStories::create([
            'userid' => $requscom,
            'artiestoriesid' => $reqplat,
            'commentses' => $inputcomments,
        ]);

        return redirect()->to('/Artiestories?GetContent=' . $reqplat1)
                        ->with('open_commentarist', $reqplat1);
    }
    public function storeGG1(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('authes')->with('alert', 'Harus login dulu.');
        } 

        $hidden = $request->input('inpbalassajahidden');
        $requscom = session('userid');
        $inputcomments = $request->input('inpbalassaja');
        $storyId = $request->input('arahan');

        BalcomStories::create([
            'userid' => $requscom,
            'commentartiestoriesid' => $hidden,
            'comment' => $inputcomments,
        ]);
        return redirect()->to('/Artiestories?GetContent=' . $hidden)
        ->with('open_commentarist', $storyId)
        ->with('open_commentbalasan', $hidden);
    }
}
