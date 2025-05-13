<?php

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
use App\Http\Controllers\App\artiestories\artiestoriescomments;
use App\Http\Controllers\App\artiestories\artiestoriesreact;
use App\Http\Controllers\App\artievides\controllerartievides;
use App\Http\Controllers\App\artiestories\controllerartiestories;
use App\Http\Controllers\App\profil\profilcontroller;
use App\Http\Controllers\App\subscribe\subscontroller;
use Illuminate\Http\Request;


use App\Models\Artiestories;
use App\Models\Artievides;
use App\Models\Artiekeles;


use Illuminate\Support\Facades\Route;
Route::get('/chat', function () {
    return view('chat');
});
Route::post('/enter-typing', [artiestoriescomments::class, 'storeGG']);
Route::post('/broadcast-typing', [artiestoriescomments::class, 'broadcast']);
Route::post('/enter-typing1', [artiestoriescomments::class, 'storeGG1']);
Route::post('/broadcast-typing1', [artiestoriescomments::class, 'broadcast1']);
Route::post('/enter-typing2', [artiestoriescomments::class, 'storeGG2']);
Route::post('/broadcast-typing2', [artiestoriescomments::class, 'broadcast2']);




# APP #
Route::controller(searcheses::class)->group(function () {
    Route::get('/searches', 'index')->name('appes.searches');
    Route::post('/searches', 'Search')->name('histories');
});
Route::post('/upload-file-artiekeles', [FileController::class, 'uploadFile'])->name('file.upload.artiekeles');
Route::post('/upload-file-artievides', [controllerartievides::class, 'uploadFile'])->name('file.upload.artievides');
Route::post('/upload-file-artiestories', [controllerartiestories::class, 'uploadFile'])->name('file.upload.artiestories');
Route::get('/', [artieses::class, 'Homes1']);
Route::get('/artieses', [artieses::class, 'Homes1']);
Route::get('/Artieses', [artieses::class, 'Homes'])->name('artieses');
Route::post('/reaksi', [artiestoriesreact::class, 'store'])->name('uprcm0');
Route::post('/uprcm0gg', [artiestoriescomments::class, 'storeGG'])->name('uprcm0gg');
Route::post('/uprcm1gg', [artiestoriescomments::class, 'storeGG1'])->name('ayokirim.komentar');
Route::post('/addsubs', [subscontroller::class, 'addsubs'])->name('addsubs');
Route::post('/reaksi3', [artiestoriesreact::class, 'store3'])->name('uprcm2');
Route::post('/reaksi2', [artiestoriesreact::class, 'store2'])->name('uprcm1');
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
Route::get('/profiles/{username}', [profilcontroller::class, 'show'])->name('profiles.show');

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

Route::get('/artiestories', function(Request $request) {
    $reqplat = $request->query('GetContent');
    return redirect()->to('/Artiestories?GetContent=' . $reqplat)->with('open_commentarist', $reqplat);
});
Route::get('/Artiestories', function (Request $request) {
    $reqplat = $request->query('GetContent');
        if (!session('isLoggedIn')) {
                $videos = Artievides::with('usericonVides')
                    ->withCount('likeVides')
                    ->orderByDesc('like_vides_count')
                    ->orderByDesc('created_at')
                    ->get();
            
                $stories = Artiestories::withCount('reactStories')
                    ->orderByDesc('react_stories_count')
                    ->with([
                        'usericonStories',
                        'ReactStories',
                        'comments.replies',
                        'comments.userComments',
                        'comments.replies.userBalcom'
                    ])
                    ->latest()
                    ->get();
            
                $articles = Artiekeles::latest()->get();
            
                $mergedFeed = [];
                $videoIndex = $storyIndex = $articleIndex = 0;
            
                while ($videoIndex < $videos->count() || $storyIndex < $stories->count() || $articleIndex < $articles->count()) {
                    for ($i = 0; $i < 6 && $videoIndex < $videos->count(); $i++) {
                        $mergedFeed[] = ['type' => 'video', 'data' => $videos[$videoIndex++]];
                    }
            
                    for ($i = 0; $i < 3 && $storyIndex < $stories->count(); $i++) {
                        $mergedFeed[] = ['type' => 'story', 'data' => $stories[$storyIndex++]];
                    }
            
                    for ($i = 0; $i < 3 && $articleIndex < $articles->count(); $i++) {
                        $mergedFeed[] = ['type' => 'article', 'data' => $articles[$articleIndex++]];
                    }
                }
        }
        if (session('isLoggedIn')) {
                $videos = Artievides::with('usericonVides')
                    ->withCount('likeVides')
                    ->orderByDesc('like_vides_count')
                    ->orderByDesc('created_at')
                    ->get();
            
                $stories = Artiestories::withCount('reactStories')
                    ->orderByDesc('react_stories_count')
                    ->with([
                        'usericonStories',
                        'ReactStories',
                        'comments.replies',
                        'comments.userComments',
                        'comments.replies.userBalcom'
                    ])
                    ->latest()
                    ->get();
                $articles = Artiekeles::latest()->get();
                $mergedFeed = [];
                $videoIndex = $storyIndex = $articleIndex = 0;
            
                while ($videoIndex < $videos->count() || $storyIndex < $stories->count() || $articleIndex < $articles->count()) {
                    for ($i = 0; $i < 6 && $videoIndex < $videos->count(); $i++) {
                        $mergedFeed[] = ['type' => 'video', 'data' => $videos[$videoIndex++]];
                    }
            
                    for ($i = 0; $i < 3 && $storyIndex < $stories->count(); $i++) {
                        $mergedFeed[] = ['type' => 'story', 'data' => $stories[$storyIndex++]];
                    }
            
                    for ($i = 0; $i < 3 && $articleIndex < $articles->count(); $i++) {
                        $mergedFeed[] = ['type' => 'article', 'data' => $articles[$articleIndex++]];
                    }
                }
        }
        return view('appes.artieses', compact('mergedFeed'))->with('open_commentarist', $reqplat);
})->name('artiestories');