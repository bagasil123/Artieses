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
                <p class="dispname">{{ $comment->userComments->username }}</p> 
                <p class="comment001">{{ $comment->commentses }}</p>
            </div>
        </div>
        <div class="wrappercom2">
        @include('appes.artiestories.rcm')
        <p class="comment001" >balas</p>
        </div>
        @include('appes.artiestories.commentses1')
        @include('appes.artiestories.js.commentarist1')
    @endforeach
    </div>
@endif
