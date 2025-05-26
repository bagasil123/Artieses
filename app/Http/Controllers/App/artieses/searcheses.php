<?php

namespace App\Http\Controllers\App\artieses;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Searches;
use Illuminate\Support\Facades\DB;

class searcheses extends Controller
{
    public function Search(Request $request)
    {
        
        if (!AuthHelper::check()) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        $request->validate([
            'search' => 'required|string',
        ]);

        Searches::create([
            'userid' => session('userid'),
            'search' => $request->search,
        ]);

        return redirect()->route('appes.searches', ['q' => $request->search]);
    }

    public function result(Request $request)
    {
        $query = $request->input('q');

        $results = DB::table('artiestories')
            ->whereNull('deltime')
            ->where(function($q) use ($query) {
                $q->where('caption', 'like', '%' . $query . '%')
                ->orWhere('kseo', 'like', '%' . $query . '%')
                ->orWhere('lseo', 'like', '%' . $query . '%');
            })
            ->latest()
            ->get();

        return view('appes.searches', compact('results', 'query'));
    }
    public function index()
    {
        $searches = Searches::where('userid', session('userid'))->latest()->get();
        return view('appes.searches', compact('searches'));
    }
}
