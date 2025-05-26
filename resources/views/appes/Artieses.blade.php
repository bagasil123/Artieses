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
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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
  @foreach ($mergedFeed as $item)
    @if ($item['type'] === 'video')
      @php $video = $item['data']; @endphp
    <div class="card-artievides1 card-artievides1{{ $video->codevides }}" id="card-artievides1{{ $video->codevides }}">
        @include('appes.artievides.artievides', ['video' => $item['data']])
    </div>
    @elseif ($item['type'] === 'story')
      @php $story = $item['data']; @endphp
        @include('appes.artiestories.artiestories', ['story' => $item['data']])
        @include('appes.artiestories.js.commentjs')
    @elseif ($item['type'] === 'article')
      @php $article = $item['data']; @endphp
            <h3>{{ $item['data']->judul }}</h3>
            <p>{{ Str::limit(strip_tags($item['data']->konten), 100) }}</p>
    @endif
@endforeach
  </div>
  </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script src="{{ asset('js/appes/artievides1.js') }}"></script>
  <script>
    const originalLog = console.log;
    console.log = function (...args) {
      if (args.some(arg => typeof arg === 'string' && arg.includes('Pusher')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing1')) || 
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('Pusher1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing'))) {
          return;
      }
      originalLog.apply(console, args);
    };        
  </script>
</html>