        @if ($comment->replies->isEmpty())
        @else
            <p class="comment001 seerepl" data-target="replies-{{ $i }}" >Lihat Balasan</p>
            <div class="replies hidden" id="replies-{{ $i }}">
                @foreach ($comment->replies as $reply)
                    <div class="reply">
                        @php
                            $username = $reply->userBalcom->username ?? 'defaultuser';
                            $improfil = $reply->userBalcom->improfil ?? 'default.png';
                            $path = $username . '/profil/' . $improfil;
                            $ext = pathinfo($improfil, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
                            <img src="{{ asset($path) }}" class="creatorstories">
                        @endif
                        <div class="dispcard">
                            <p>{{ $reply->userBalcom->username }}</p>
                            <p>{{ $reply->comment }}</p>
                        </div>
                    </div>
                    @include('appes.artiestories.rcm1')
                @endforeach
            </div>
    @endif