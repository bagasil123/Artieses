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
        <div class="wrapper">
            @if($results->isEmpty())
                <p>Konten yang Anda cari tidak ditemukan.</p>
            @else
                {{-- Loop ini sekarang hampir identik dengan halaman index Anda --}}
                @foreach ($results as $item)
                    @if ($item['type'] === 'video')
                        @php $video = $item['data']; @endphp
                        <div class="card-artievides1 card-artievides1{{ $video->codevides }}" id="card-artievides1{{ $video->codevides }}">
                            @include('appes.artievides.artievides', ['video' => $video])
                        </div>
                    @elseif ($item['type'] === 'story')
                        @php $story = $item['data']; @endphp
                        @include('appes.artiestories.artiestories', ['story' => $story])
                        @include('appes.artiestories.js.commentjs')
                    @elseif ($item['type'] === 'article')
                        @php $article = $item['data']; @endphp
                        {{-- Anda bisa membuat partial view untuk artikel agar lebih rapi --}}
                        <div class="card-article"> {{-- Contoh wrapper --}}
                            <h3>{{ $article->judul }}</h3>
                            <p>{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
</html>
