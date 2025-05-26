        <a href="/Artievides?GetContent={{ $video->codevides }}" class="">
          <div class="video-container">
            <video width="100%" muted class="hover-video" poster="{{ url('/Artiethumb/' . basename($video->thumbnail) . '?GetContent=' . $video->codevides) }}">
              <source src="{{ url('/Artievides/' . basename($video->video) . '?GetContent=' . $video->codevides) }}" type="video/mp4">
            </video>
            <script>
              function formatTime(seconds) {
                  const min = Math.floor(seconds / 60).toString().padStart(2, '0');
                  const sec = Math.floor(seconds % 60).toString().padStart(2, '0');
                  return `${min}:${sec}`;
              }

              document.addEventListener('DOMContentLoaded', function () {
                  const containers = document.querySelectorAll('.video-container');
                  const videos = document.querySelectorAll('.hover-video');
                  containers.forEach(container => {
                      const video = container.querySelector('video');
                      const timer = container.querySelector('.video-timer');

                      video.addEventListener('loadedmetadata', () => {
                          const duration = formatTime(video.duration);
                          timer.textContent = `00:00 / ${duration}`;
                      });

                      video.addEventListener('timeupdate', () => {
                          const current = formatTime(video.currentTime);
                          const duration = formatTime(video.duration);
                          timer.textContent = `${current} / ${duration}`;
                      });

                      video.addEventListener('mouseenter', () => video.play());
                      video.addEventListener('mouseleave', () => {
                          video.pause();
                          video.currentTime = 0;
                      });
                  });
                  videos.forEach(video => {
                      video.addEventListener('mouseenter', () => {
                          video.play();
                      });
                      video.addEventListener('mouseleave', () => {
                          video.pause();
                          video.currentTime = 0;

                          const src = video.querySelector('source').getAttribute('src');
                          video.querySelector('source').setAttribute('src', '');
                          video.load();

                          setTimeout(() => {
                              video.querySelector('source').setAttribute('src', src);
                              video.load();
                          }, 0);
                      });
                  });
              });
            </script>
          <div class="video-timer">00:00 / 00:00</div>
          </div><br>
          <div class="cabot-artievides">
        @php
          $username = $video->usericonVides->username ?? 'defaultuser';
          $improfil = $video->usericonVides->improfil ?? 'default.png';
          $path = $username . '/profil/' . $improfil;
          $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
          <div class="creator-1">
        <a href="{{ route('profiles.show', ['username' => $username]) }}">
            <img src="{{ asset($path) }}" class="creatorvides">
        </a>
          </div>
        @endif
        <a href="{{ route('profiles.show', ['username' => $username]) }}">
          <p class="h5-artievides">{{ $username }}</p>
        </a>
        <h3 class="h3-artievides">{{ Str::limit($video->judul, 15) }}</h3>
        @php
            $now = \Carbon\Carbon::now();
            $waktu = $video->created_at;
            $diffInMinutes1 = $waktu->diffInMinutes($now); 
            $diffInHours1 = $waktu->diffInHours($now);
            $diffInDays1 = $waktu->diffInDays($now);
            $diffInWeeks1 = $waktu->diffInWeeks($now);
            $diffInMonths1 = $waktu->diffInMonths($now);
            $diffInYears1 = $waktu->diffInYears($now);

            
            $diffInMinutes = (int) $diffInMinutes1;
            $diffInHours = (int) $diffInHours1;
            $diffInDays = (int) $diffInDays1;
            $diffInWeeks = (int) $diffInWeeks1;
            $diffInMonths = (int) $diffInMonths1;
            $diffInYears = (int) $diffInYears1;

            if ($diffInMinutes < 60) {
                $timeAgo = $diffInMinutes . ' menit yang lalu';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays < 7) {
                $timeAgo = $diffInDays . ' hari yang lalu';
            } elseif ($diffInWeeks < 4) {
                $timeAgo = $diffInWeeks . ' minggu yang lalu';
            } elseif ($diffInMonths < 12) {
                $timeAgo = $diffInMonths . ' bulan yang lalu';
            } else {
                $timeAgo = $diffInYears . ' tahun yang lalu';
            }
            function formatLike($n) {
              if ($n >= 1000000000) return round($n / 1000000000, 1) . 'm';
              elseif ($n >= 1000000) return round($n / 1000000, 1) . 'jt';
              elseif ($n >= 1000) return round($n / 1000, 1) . 'rb';
              return $n;
            } 
        @endphp
        <p class="date-artievides" style="margin-top: 30px;">{{ formatAngka($video->like_vides_count ?? 0) }} Disukai | {{ $timeAgo }}</p>
        </div>
      </a>
      