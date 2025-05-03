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
<body>
  @if(session('alert'))
      <div class="feedback error">
          {{ session('alert') }}
      </div>
  @endif
  <div class="main-content">
    @yield('content')
  </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
</html>
