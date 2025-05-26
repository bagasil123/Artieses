<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artieprofil.css') }}">
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
        @php
          $username = $user->username ?? 'defaultuser';
          $improfil = $user->improfil ?? 'default.png';
          $path = $username . '/profil/' . $improfil;
          $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
  <div class="card-name">
    @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
        <img src="{{ asset($path) }}" class="creatorprofile" alt="{{ asset($path) }}">
    @endif
    <div class="text-section">
      <div class="top-subs">
        <span class="nameprofiles">{{ $user->username }}</span>
          @if($user->username == session('username'))
          @else
              @php
                  $isSubscribed = \App\Models\Subs::where('subscriber', session('userid'))->where('subscribing', $user->userid)->first();
              @endphp
              @if($isSubscribed)
                  <button class="btnsubs btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Unsubscribe</button>
              @else
                  <button class="btnsubs btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Subscribe</button>
              @endif
          @endif

          <script>
            document.addEventListener('DOMContentLoaded', function () {
                const subscribeButtons = document.querySelectorAll('.btnsubs');

                subscribeButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const subscribing = this.id;

                        if (subscribing) {
                            fetch("{{ route('addsubs') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    subscribing: subscribing
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log(data);
                                if (!data.logged_in) {
                                    sessionStorage.setItem('alert', data.alert);
                                    sessionStorage.setItem('form', data.form);
                                    window.location.href = data.redirect;
                                    return;
                                }

                                if (data.csrf) {
                                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                                }

                                // Opsional: update tampilan tombol
                                if (data.subscribed) {
                                    button.textContent = 'Subscribed';
                                    button.classList.add('subscribed');
                                } else {
                                    button.textContent = 'Subscribe';
                                    button.classList.remove('subscribed');
                                }

                                console.log(data.message);
                            })
                            .catch(err => {
                                console.error('Fetch error:', err);
                            });
                        } else {
                            console.error('User ID tidak valid!');
                        }
                    });
                });
            });
          </script>
      </div>
      <div class="subs">
        <p>{{ $user->stories->count() + $user->videos->count() + $user->artiekeles->count() }} Konten</p>
        <p>{{ $user->subscriber->count() }} Subscriber</p>
        <p>{{ $user->subscribing->count() }} Subscribing</p>
      </div>
      <div class="bio">
        <p>{{ $user->bio }}</p>
      </div>
    </div>
  </div>

  @foreach($videscontent as $video)
    {{-- tampilkan video atau story milik user --}}
  @endforeach
</div>
</div>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script src="{{ asset('js/appes/artievides1.js') }}"></script>
</html>