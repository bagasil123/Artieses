@php 
    $storyId = $story->artiestoriesid;
    $storyCode = $story->coderies;
@endphp
<div id="commentarist-{{ $storyCode }}" class="commentarist commentarist-{{ $storyCode }} {{ isset($open_commentarist) && $open_commentarist == $storyCode ? 'block' : 'hidden' }} {{ isset($open_commentarist) == $storyCode ? 'block' : 'hidden' }}">
    <div class="commentaristcardimg">
        @foreach ($images as $index => $img)
            <img src="{{ asset($img->konten) }}"
                class="crimg cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                id="cbtnry001-{{ $storyCode }}-{{ $index }}">
        @endforeach
        <button id="previmg-{{ $storyCode }}-comment" class="nav-button prev1">◀</button>
        <button id="nextimg-{{ $storyCode }}-comment" class="nav-button next1">▶</button>
        </div>
    <div class="commentaristcre">
        @include('appes.artiestories.brecreies')
        <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   
        <p class="captionStories">{{ $story->caption }}</p>
        @include('appes.artiestories.cek')
        @include('appes.artiestories.reacted')
        @include('appes.artiestories.reacted2')
        <div class="rbtnry001">
        <button class="rbtnry rbtnry2-{{ $storyCode }}" style="margin-top: 8px; margin-left:100px;" id="rbtnry2-{{ $storyCode }}">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/likelm.png') }}"
                data-dark="{{ asset('partses/likedm.png') }}">
        </button>
        <button class="rbtnry cbtnry1-{{ $storyCode }}" style="margin-top: 8px; margin-left:100px;">
            <img class="iclikestory" loading="lazy"
            data-light="{{ asset('partses/commentlm.png') }}"
            data-dark="{{ asset('partses/commentdm.png') }}">
        </button>
        </div><br><br><br><br><br>
        @include('appes.artiestories.commentses')
    </div>
    <form action="uprcm0gg" method="POST">
        @csrf
    <div class="chat chat-{{ $storyCode }}">
            <input type="text" class="inpcom inpcom-{{ $storyCode }}" name="inputcommentnya" id="inpcom-{{ $storyCode }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $storyId }}" name="commentses">
            <input type="hidden" value="{{ $storyCode }}" name="commentsesarah">
            <button type="button" class="balinpcom balinpcom-{{ $storyCode }}" id="balinpcom-{{ $storyCode }}">&times;</button>
            <button type="submit" class="sendcom sendcom-{{ $storyCode }}" id="sendcom-{{ $storyCode }}">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/sendcomlm.png') }}"
                data-dark="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>
    </form>
        @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>