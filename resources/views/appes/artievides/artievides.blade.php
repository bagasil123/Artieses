<a href="/Artievides?GetContent={{ $video->codevides }}" class="">
  <div class="video-container">
    <video width="100%" muted class="hover-video" poster="{{ url('/Artiethumb/' . basename($video->thumbnail) . '?GetContent=' . $video->codevides) }}">
      <source src="{{ url('/Artievides/' . basename($video->video) . '?GetContent=' . $video->codevides) }}" type="video/mp4">
    </video>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const videos = document.querySelectorAll('.hover-video');
          videos.forEach(video => {
              video.addEventListener('mouseenter', () => {
                  const playPromise = video.play();
                  if (playPromise !== undefined) {
                      playPromise.catch(error => {
                      });
                  }
              });
              video.addEventListener('mouseleave', () => {
                  video.pause();
                  video.currentTime = 0;
              });
              const container = video.closest('.video-container');
              if (container) {
                  const timer = container.querySelector('.video-timer');
                  if (timer) {
                      const formatTime = (seconds) => {
                          const min = Math.floor(seconds / 60).toString().padStart(2, '0');
                          const sec = Math.floor(seconds % 60).toString().padStart(2, '0');
                          return `${min}:${sec}`;
                      };
                      video.addEventListener('loadedmetadata', () => {
                          timer.textContent = `00:00 / ${formatTime(video.duration)}`;
                      });
                      video.addEventListener('timeupdate', () => {
                          timer.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
                      });
                  }
              }
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
    <p class="date-artievides" style="margin-top: 30px;">
      {{ \App\Helpers\inthelp::formatAngka($video->like_vides_count ?? 0) }} Disukai | 
      {{ \App\Helpers\inthelp::formatWaktu($video->created_at) }}
    </p>
  </div>
</a>