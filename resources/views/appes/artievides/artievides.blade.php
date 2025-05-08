
        <a href="#" class="">
          <div class="video-container">
            <video width="100%" muted class="hover-video">
              <source src="{{ asset($video->video) }}" type="video/mp4">
            </video>
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
            <img src="{{ asset($path) }}" class="creatorvides">
          </div>
        @endif
        <p class="h5-artievides">{{ $username }}</p>
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
        @endphp
        <p class="date-artievides" style="margin-top: 30px;">{{ 0 + $video->like_vides_count }} Disukai | {{ $timeAgo }}</p>
        </div>
      </a>