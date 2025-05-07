@php $storyId = $story->artiestoriesid; @endphp
<div id="commentarist-{{ $storyId }}" class="commentarist commentarist-{{ $storyId }} {{ session('open_commentarist') == $storyId ? 'block' : 'hidden' }}    ">
    <div class="commentaristcardimg">
        <img src="{{ $story->konten }}" class="crimg">
    </div>
    <div class="commentaristcre">
        @include('appes.artiestories.brecreies')
        <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   
        <p class="captionStories">{{ $story->caption }}</p>
        @include('appes.artiestories.cek')
        @include('appes.artiestories.reacted')
        @include('appes.artiestories.reacted2')
        <div class="rbtnry001">
        <button class="rbtnry rbtnry2-{{ $storyId }}" style="margin-top: 8px; margin-left:100px;" id="rbtnry2-{{ $storyId }}">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/likelm.png') }}"
                data-dark="{{ asset('partses/likedm.png') }}">
        </button>
        <button class="rbtnry cbtnry1-{{ $storyId }}" style="margin-top: 8px; margin-left:100px;">
            <img class="iclikestory" loading="lazy"
            data-light="{{ asset('partses/commentlm.png') }}"
            data-dark="{{ asset('partses/commentdm.png') }}">
        </button>
        </div><br><br><br><br><br>
        @include('appes.artiestories.commentses')
    </div>
    <form action="uprcm0gg" method="POST">
        @csrf
    <div class="chat chat-{{ $storyId }}">
            <input type="text" class="inpcom inpcom-{{ $storyId }}" name="inputcommentnya" id="inpcom-{{ $storyId }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $storyId }}" name="commentses">
            <button type="button" class="balinpcom balinpcom-{{ $storyId }}" id="balinpcom-{{ $storyId }}">&times;</button>
            <button type="submit" class="sendcom sendcom-{{ $storyId }}" id="sendcom-{{ $storyId }}">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/sendcomlm.png') }}"
                data-dark="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>
    </form>
        @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyId }}" id="closeCommentarist-{{ $storyId }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>