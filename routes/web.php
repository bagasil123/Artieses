<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\forgetesR1;
use App\Http\Controllers\Auth\forgetesR2;
use App\Http\Controllers\Auth\loges;
use App\Http\Controllers\Auth\registeres;
use App\Http\Controllers\captcha\captchaes;
use App\Http\Controllers\captcha\captchaesR1;
use App\Http\Controllers\captcha\captchaesR2;
use App\Http\Controllers\App\artieses\searcheses;
use App\Http\Controllers\App\artieses\artieses;
use App\Http\Controllers\App\artiekeles\FileController;
use App\Http\Controllers\App\artievides\controllerartievides;
use App\Http\Controllers\App\artiestories\controllerartiestories;
use Illuminate\Support\Facades\Auth;


use App\Models\Artiestories;
use App\Models\Artievides;
use App\Models\Artiekeles;

# APP #
Route::controller(searcheses::class)->group(function () {
    Route::get('/searches', 'index')->name('appes.searches');
    Route::post('/searches', 'Search')->name('histories');
});
Route::post('/upload-file-artiekeles', [FileController::class, 'uploadFile'])->name('file.upload.artiekeles');
Route::post('/upload-file-artievides', [controllerartievides::class, 'uploadFile'])->name('file.upload.artievides');
Route::post('/upload-file-artiestories', [controllerartiestories::class, 'uploadFile'])->name('file.upload.artiestories');
Route::get('/', function () {
    if (!session('isLoggedIn')) {
        $videos = Artievides::with('usericonVides')->withCount('likeVides')->orderByDesc('like_vides_count')->orderByDesc('created_at')->take(6)->get();
        $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
        $articles = Artiekeles::latest()->take(3)->get();
    }
    if (session('isLoggedIn')) {
        $videos = Artievides::with('usericonVides')->withCount('likeVides')->orderByDesc('like_vides_count')->orderByDesc('created_at')->take(6)->get();
        $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
        $articles = Artiekeles::latest()->take(3)->get();
    }
    return view('appes.artieses', compact('videos', 'stories', 'articles'));
});
Route::get('/artieses', function () {
    if (!session('isLoggedIn')) {
        $videos = Artievides::with('usericonVides')->withCount('likeVides')->orderByDesc('like_vides_count')->orderByDesc('created_at')->take(6)->get();
        $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
        $articles = Artiekeles::latest()->take(3)->get();
    }
    if (session('isLoggedIn')) {
        $videos = Artievides::with('usericonVides')->withCount('likeVides')->orderByDesc('like_vides_count')->orderByDesc('created_at')->take(6)->get();
        $stories = Artiestories::withCount('reactStories')->orderByDesc('react_stories_count')->with('usericonStories', 'ReactStories', 'comments.replies', 'comments.userComments', 'comments.replies.userBalcom')->latest()->take(3)->get();
        $articles = Artiekeles::latest()->take(3)->get();
    }
    return view('appes.artieses', compact('videos', 'stories', 'articles'));
})->name('artieses');
Route::post('/reaksi', [controllerartiestories::class, 'store'])->name('uprcm0');
Route::post('/uprcm0gg', [controllerartiestories::class, 'storeGG'])->name('uprcm0gg');
Route::post('/reaksi3', [controllerartiestories::class, 'store3'])->name('uprcm2');
Route::post('/reaksi2', [ControllerArtiestories::class, 'store2'])->name('uprcm1');

Route::post('/cek-login', function () {
})->name('cek.login');


Route::get('/refresh-csrf', function () {
    return response()->json(['csrf' => csrf_token()]);
});
Route::post('/set-alert-session', function (\Illuminate\Http\Request $request) {
    session()->flash('alert', $request->input('alert'));
    session()->flash('form', $request->input('form'));
    return response()->json(['status' => 'ok']);
})->name('set.alert.session');

# AUTHENTICATION #
Route::get('/authes', function () {
    return view('authes.authes');
})->name('authes');
Route::post('/login', [loges::class, 'login'])->name('login.action');
Route::post('/register', [registeres::class, 'register'])->name('register.action');
Route::post('/forget', [forgetesR1::class, 'forget'])->name('forget.action');
Route::post('/forget1', [forgetesR2::class, 'forget1'])->name('forget1.action');
Route::get('/logout', [loges::class, 'logout']);
Route::get('/logineses', [loges::class, 'logines']);

# CAPTCHA #
Route::post('/captchada', [captchaesR1::class, 'captcha'])->name('captcha.action');
Route::post('/captcha1', [captchaesR2::class, 'captcha1'])->name('captcha1.action');
Route::get('/hapus-captcha', [captchaes::class, 'hapuscaptcha'])->name('hapus.captcha');
Route::get('/get-random-images', [captchaesR1::class, 'RandomImages']);

# CHECK LOGIN #
Route::get('/clartiekeles', [artieses::class, 'clartiekeles']);
Route::get('/clartievides', [artieses::class, 'clartievides']);
Route::get('/clartiestories', [artieses::class, 'clartiestories']);


# ARTIEKELES #
Route::get('/artiekeles', function(){
    return view('appes.artiekeles');
});