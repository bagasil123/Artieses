        @php
            $now = \Carbon\Carbon::now();
            $waktunya = $comment->created_at;
            $diffInMinutes001 = $waktunya->diffInMinutes($now);
            $diffInHours001 = $waktunya->diffInHours($now);
            $diffInDays001 = $waktunya->diffInDays($now);
            $diffInWeeks001 = $waktunya->diffInWeeks($now);
            $diffInMonths001 = $waktunya->diffInMonths($now);
            $diffInYears001 = $waktunya->diffInYears($now);

            
            $diffInMinutes = (int) $diffInMinutes001;
            $diffInHours = (int) $diffInHours001;
            $diffInDays = (int) $diffInDays001;
            $diffInWeeks = (int) $diffInWeeks001;
            $diffInMonths = (int) $diffInMonths001;
            $diffInYears = (int) $diffInYears001;

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
        <p class="captionStories gg1">{{ $timeAgo }}</p>