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
  @if(session('alert'))
    <div class="feedback error">
      {{ session('alert') }}
    </div>
  @endif
  <div class="not-login {{ session('bukasiprofil') == session('isLoggedIn') ? 'hidden' : 'block'}}">
  </div>
  <div class="card-main">
  </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script src="{{ asset('js/appes/artievides1.js') }}"></script>
</html>