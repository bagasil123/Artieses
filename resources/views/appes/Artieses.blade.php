<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiekeles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artievides.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiestories.css') }}">
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
  @include('partses.baries')
</head>
<body class="dark-mode">
  @if(session('alert'))
    <div class="feedback error">
      {{ session('alert') }}
    </div>
  @endif
  <div class="card-main">
  {{-- Videos --}}
    <div class="wrapper">
      @foreach($videos as $video)
        <a href="#" class="card-artievides">
          <div class="video-container">
            <video width="100%" muted class="hover-video">
              <source src="{{ asset($video->video) }}" type="video/mp4">
            </video>
          <div class="video-timer">00:00 / 00:00</div>
          </div><br>
        @php
          $username = $video->usericonVides->username ?? 'defaultuser';
          $improfil = $video->usericonVides->improfil ?? 'default.png';
          $path = $username . '/profil/' . $improfil;
          $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
          <div class="creator-1">
            <img src="{{ asset($path) }}" class="creatorvides">
          </div>
        @endif
        <h3 class="h3-artievides">{{ Str::limit($video->judul, 15) }}</h3>
        <p class="p-artievides" style="margin-top: 30px;">{{ 0 + $video->likeartievides }} Disukai</p>
      </a>
    @endforeach
    </div>
    <div class="artievides-wrapper1">
    @foreach($videos as $video)
    <div class="card-artievides">
      <a href="#" class="a-artievides">{{ $video->usericonVides->username}}</a>
    </div>
    @endforeach
    </div>
    
    {{-- Stories --}}
    <div class="wrapper">
    @foreach($stories as $story)
      <div class="card-artiestories">
        @php
          $username = $story->usericonStories->username ?? 'defaultuser';
          $improfil = $story->usericonStories->improfil ?? 'default.png';
          $path = $username . '/profil/' . $improfil;
          $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
          <div class="creator-1">
            <img src="{{ asset($path) }}" class="creatorstories">
          </div>
        @endif
        <p class="p-artiestories">{{ $story->usericonStories->username }}</p>
        
        <a href="#">
        <img src="{{ $story->konten }}" class="cardstories">
        </a>
        <div class="artiestories1">
        <a href="#">
          <img class="iclikestory" loading="lazy"
            data-light="{{ asset('partses/likelm.png') }}"
            data-dark="{{ asset('partses/likedm.png') }}">
        </a>
        </div>
        <p class="captionStories">{{ $story->caption }}</p>
      </div>
    @endforeach
    </div>
    {{-- Articles --}}
    @foreach($articles as $article)
      <div class="card-artiekeles">
          <h3>{{ $article->judul }}</h3>
          <p>{{ Str::limit(strip_tags($article->konten), 100) }}</p>
      </div>
    @endforeach
  </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script src="{{ asset('js/appes/artievides1.js') }}"></script>
</html>