@if ($story->comments->isEmpty())
    <p class="noncomments">Belum ada komentar</p>
@else
<div class="wrappercom1">
    @foreach ($story->comments as $i => $comment)
        <div class="cardcom001">
            @php
                $username = $comment->userComments->username ?? 'defaultuser';
                $improfil = $comment->userComments->improfil ?? 'default.png';
                $path = $username . '/profil/' . $improfil;
                $ext = pathinfo($improfil, PATHINFO_EXTENSION);
            @endphp
            @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
                <img src="{{ asset($path) }}" class="creatorstories">
            @endif
            <div class="dispcard">
                <div class="ddispcanam">
                <p class="dispname">{{ $comment->userComments->username }}</p> 
                </div>
                <p class="comment001">{{ $comment->commentses }}</p>
            </div>
        </div>
        <div class="wrappercom2">
        @include('appes.artiestories.rcm')
        @include('appes.artiestories.cek1')
        </div>
        @include('appes.artiestories.commentses1')
    @endforeach
    </div>
@endif
