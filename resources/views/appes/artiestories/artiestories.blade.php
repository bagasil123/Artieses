    @php $storyCode = $story->coderies; @endphp
    <div class="card-artiestories1" id="card-artiestories-{{ $storyCode }}">
        @include('appes.artiestories.brecreies')
        <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   @php
    $images = $story->images->sortBy('artiestoriesimgid'); // urut berdasarkan created_at ASC
    $totalImages = $images->count();
@endphp

<div id="image-container-{{ $storyCode }}" class="image-container">
    @foreach ($images as $index => $img)
        <img src="{{ asset($img->konten) }}"
            class="cardstories cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
            id="cbtnry1-{{ $storyCode }}-{{ $index }}">
    @endforeach

    <button id="previmg-{{ $storyCode }}" class="nav-button prev">◀</button>
    <button id="nextimg-{{ $storyCode }}" class="nav-button next">▶</button>
</div>

<script>
    let currentIndex{{ $storyCode }} = 0;

    function showImage(storyCode, index, total) {
        for (let i = 0; i < total; i++) {
            const img = document.getElementById(`cbtnry1-${storyCode}-${i}`);
            if (img) {
                img.classList.add('hidden');
            }
        }
        const activeImg = document.getElementById(`cbtnry1-${storyCode}-${index}`);
        if (activeImg) {
            activeImg.classList.remove('hidden');
        }
    }

    function nextImage(storyCode, total) {
        if (typeof window[`currentIndex${storyCode}`] !== 'undefined') {
            window[`currentIndex${storyCode}`] = (window[`currentIndex${storyCode}`] + 1) % total;
            showImage(storyCode, window[`currentIndex${storyCode}`], total);
        }
    }

    function prevImage(storyCode, total) {
        if (typeof window[`currentIndex${storyCode}`] !== 'undefined') {
            window[`currentIndex${storyCode}`] =
                (window[`currentIndex${storyCode}`] - 1 + total) % total;
            showImage(storyCode, window[`currentIndex${storyCode}`], total);
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        let currentIndex{{ $storyCode }} = 0;
        const total{{ $storyCode }} = {{ $totalImages }};
        const storyCode = "{{ $storyCode }}";

        function showImage(index) {
            for (let i = 0; i < total{{ $storyCode }}; i++) {
                const img = document.getElementById(`cbtnry1-${storyCode}-${i}`);
                if (img) img.classList.add('hidden');
            }
            const activeImg = document.getElementById(`cbtnry1-${storyCode}-${index}`);
            if (activeImg) activeImg.classList.remove('hidden');
        }

        document.getElementById(`nextimg-${storyCode}`)?.addEventListener('click', function () {
            currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} + 1) % total{{ $storyCode }};
            showImage(currentIndex{{ $storyCode }});
        });

        document.getElementById(`previmg-${storyCode}`)?.addEventListener('click', function () {
            currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} - 1 + total{{ $storyCode }}) % total{{ $storyCode }};
            showImage(currentIndex{{ $storyCode }});
        });

        // Untuk elemen dalam .commentaristcardimg
    let currentIndexComment{{ $storyCode }} = 0;
    const totalComment{{ $storyCode }} = {{ $totalImages }};

    // Fungsi untuk menampilkan gambar dalam commentaristcardimg
    function showImageComment(index) {
        for (let i = 0; i < total{{ $storyCode }}; i++) {
        const imagesComment = document.getElementById(`cbtnry001-${storyCode}-${i}`);
        if (imagesComment) imagesComment.classList.add('hidden');
    }
        const activeImgComment = document.getElementById(`cbtnry001-${storyCode}-${index}`);
        if (activeImgComment) {activeImgComment.classList.remove('hidden');}
    }

    // Event untuk tombol Next pada commentaristcardimg
    document.getElementById(`nextimg-{{ $storyCode }}-comment`)?.addEventListener('click', function () {
        currentIndexComment{{ $storyCode }} = (currentIndexComment{{ $storyCode }} + 1) % totalComment{{ $storyCode }};
        showImageComment(currentIndexComment{{ $storyCode }});
            currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} + 1) % total{{ $storyCode }};
            showImage(currentIndex{{ $storyCode }});
    });

    // Event untuk tombol Prev pada commentaristcardimg
    document.getElementById(`previmg-{{ $storyCode }}-comment`)?.addEventListener('click', function () {
        currentIndexComment{{ $storyCode }} = (currentIndexComment{{ $storyCode }} - 1 + totalComment{{ $storyCode }}) % totalComment{{ $storyCode }};
        showImageComment(currentIndexComment{{ $storyCode }});
            currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} - 1 + total{{ $storyCode }}) % total{{ $storyCode }};
            showImage(currentIndex{{ $storyCode }});
    });
    });
</script>

        @include('appes.artiestories.reacted')
        <div class="artiestories1" style="margin-left:10px; margin-top:10px;">
        @include('appes.artiestories.reacted1')
        <button class="rbtnry rbtnry-{{ $storyCode }}" id="rbtnry1-{{ $storyCode }}">
            <input type="hidden" name="rbtnry[{{ $storyCode }}]" value=" {{ $storyCode }} ">
            <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/likelm.png') }}"
                data-dark="{{ asset('partses/likedm.png') }}">
        </button>
        @include('appes.artiestories.commentarist')
        <button class="rbtnry cbtnry1-{{ $storyCode }}" id="cbtnry1-{{ $storyCode }}">
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