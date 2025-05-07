        @php
            $check = $reply->rcm2->pluck('reaksi')->unique();
            
            $getreactsuka = $check->where('reaksi', 'suka')->first();
            $getreactsenang = $check->where('reaksi', 'senang')->first();
            $getreactsedih = $check->where('reaksi', 'sedih')->first();
            $getreactmarah = $check->where('reaksi', 'marah')->first();
            $getreactketawa = $check->where('reaksi', 'ketawa')->first();
            
            $reactions = [
                'suka' => $getreactsuka,
                'marah' => $getreactmarah,
                'sedih' => $getreactsedih,
                'ketawa' => $getreactketawa,
                'senang' => $getreactsenang,
            ];
            $rcm2 = $reply->balcomstoriesid;
        @endphp
            @if($check->isEmpty()) 
                @include('appes.artiestories.reacted5')
                <p class="comment0011 rbtnry5-{{ $rcm2 }}" id="rbtnry5-{{ $rcm2 }}">suka</p>
                @include('appes.artiestories.js.commentarist3')
            @else
                <div class="iclikeswrap rbtnry6-{{ $rcm2 }}" id="rbtnry6-{{ $rcm2 }}">
                @foreach($check as $reaksi)
                    @include('appes.artiestories.reacted6')
                    <img src="{{ asset('partses/reaksi/' . $reaksi . '.png') }}" width="25px" height="25px">
                    @include('appes.artiestories.js.commentarist4')
                @endforeach
                </div>
        @endif