
    @php $storyId = $story->artiestoriesid; @endphp
    <div class="card-artiestories" id="card-artiestories-{{ $storyId }}">
        @include('appes.artiestories.brecreies')
        <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   
        <img src="{{ $story->konten }}" class="cardstories cardstories-{{ $storyId }}" id="cbtnry1-{{ $storyId }}">
        @include('appes.artiestories.reacted')
        <div class="artiestories1" style="margin-left:10px; margin-top:10px;">
        @include('appes.artiestories.reacted1')
        <button class="rbtnry rbtnry-{{ $storyId }}" id="rbtnry1-{{ $storyId }}">
            <input type="hidden" name="rbtnry[{{ $storyId }}]" value=" {{ $storyId }} ">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/likelm.png') }}"
                data-dark="{{ asset('partses/likedm.png') }}">
        </button>
        @include('appes.artiestories.commentarist')
        <button class="rbtnry cbtnry1-{{ $storyId }}" id="cbtnry1-{{ $storyId }}">
            <img class="iclikestory" loading="lazy"
            data-light="{{ asset('partses/commentlm.png') }}"
            data-dark="{{ asset('partses/commentdm.png') }}">
        </button>
        </div>
        <p style="margin-top: 10px; margin-left:10px; font-size:13px;">{{ 0 + $story->react_stories_count }} Reaksi</p>
        <p class="captionStories">{{ $story->caption }}</p>
        @include('appes.artiestories.cek')
      </div>
      @include('appes.artiestories.js.commentarist')