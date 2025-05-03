<?php

namespace App\Http\Controllers\App\artieses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Searches;

class searcheses extends Controller
{
    public function Search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);
        Searches::create([
            'userid' => session('userid'),
            'search' => $request->search,
        ]);
        return redirect()->route('appes.searches');
    }

    public function index()
    {
        $searches = Searches::where('userid', session('userid'))->latest()->get();
        return view('appes.searches', compact('searches'));
    }
}
