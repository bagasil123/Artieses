<?php

namespace App\Http\Controllers\App\profil;

use App\Http\Controllers\Controller;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Http\Request;

class profilcontroller extends Controller
{
    public function Profileses(Request $request)
    {
        if (!session('isLoggedIn')) {
            $videos = Artievides::with('usericonVides')->withCount('likeVides')->latest()->get();;
            $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
            $articles = Artiekeles::latest()->get();
        }
        if (session('isLoggedIn')) {
            $videos = Artievides::with('usericonVides')->withCount('likeVides')->latest()->get();;
            $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
            $articles = Artiekeles::latest()->get();
        }
        return view('appes.Artieprofil', compact('videos', 'stories', 'articles'));
    }
}
