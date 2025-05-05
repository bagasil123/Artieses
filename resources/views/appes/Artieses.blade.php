<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiekeles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artievides.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiestories.css') }}">
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
  @include('partses.baries')
</head>
<body class="dark-mode">
  <!-- Debug route -->
{{-- {{ route('uprcm0') }} --}}

  @if(session('alert'))
    <div class="feedback error">
      {{ session('alert') }}
    </div>
  @endif
  <div class="card-main">
  {{-- Videos --}}
    <div class="wrapper">
      @include('appes.artievides.artievides')
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
      @include('appes.artiestories.artiestories')
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