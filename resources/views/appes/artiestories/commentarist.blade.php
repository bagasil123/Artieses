@php 
    $storyCode = $story->coderies;
@endphp
<div id="commentarist-{{ $storyCode }}" class="commentarist commentarist-{{ $storyCode }} {{ isset($open_commentarist) && $open_commentarist == $storyCode ? 'block' : 'hidden' }} {{ isset($open_commentarist) == $storyCode ? 'block' : 'hidden' }}" data-story="{{ $storyCode }}">
    <div class="commentaristcardimg">
        @foreach ($images as $index => $img)
                @php
                    $isImage = in_array(pathinfo($img->konten, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                    $isVideo = in_array(pathinfo($img->konten, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']);
                @endphp
                @if ($isImage)
                    <img src="{{ url('/Artiestoriesimg/' . basename($img->konten) . '?GetContent=' . $story->coderies) }}"
                        class="crimg cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                        id="cbtnry001-{{ $storyCode }}-{{ $index }}" >
                @elseif ($isVideo)
                    <video controls
                        class="crimg cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                        id="cbtnry001-{{ $storyCode }}-{{ $index }}" tabindex="-1">
                        <source src="{{ url('/Artiestoriesvideo/' . basename($img->konten) . '?GetContent=' . $story->coderies) }}" type="video/mp4">
                        Browsermu tidak mendukung video.
                    </video>
                @endif
        @endforeach
        <button id="previmg-{{ $storyCode }}-comment" class="nav-button prev1">◀</button>
        <button id="nextimg-{{ $storyCode }}-comment" class="nav-button next1">▶</button>
        </div>
    <div class="commentaristcre">
        @include('appes.artiestories.brecreies')
        <a href="{{ route('profiles.show', ['username' => $story->usericonStories->username]) }}">
            <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   
        </a>
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
    <div class="brcmt hidden" id="divbrcmt-{{ $storyCode }}">
        <p id="brcmt-{{ $storyCode }}"></p>
    </div>
    <div class="chat chat-{{ $storyCode }}">
        <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp" id="importbtn-{{ $storyCode }}">
        <input type="text" class="inpcom inpcom-{{ $storyCode }}" id="inpcom-{{ $storyCode }}" placeholder="Kirim komentar..." required/>
        <input type="file" accept="image/*" id="filepicker-{{ $storyCode }}" class="hidden" />
        <input type="hidden" value="{{ $storyCode }}" id="commentses-{{ $storyCode }}">
        <button type="button" class="balinpcom balinpcom-{{ $storyCode }} hidden" id="balinpcom-{{ $storyCode }}">&times;</button>
        <button type="submit" class="sendcom sendcom-{{ $storyCode }}" id="sendcom-{{ $storyCode }}">
            <img class="iclikestory" loading="lazy" src="{{ asset('partses/sendcomdm.png') }}">
        </button>
    </div>      
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const storyCode = '{{ $storyCode }}';
            const input = document.getElementById('inpcom-' + storyCode);
            const fileInput = document.getElementById('filepicker-' + storyCode);
            const importBtn = document.getElementById('importbtn-' + storyCode);
            importBtn.addEventListener('click', () => {
                fileInput.click();
            });
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        showImagePreview(event.target.result, storyCode);
                    };
                    reader.readAsDataURL(file);
                }
            });
            input.addEventListener('paste', function (e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") === 0) {
                        const file = items[i].getAsFile();
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            showImagePreview(event.target.result, storyCode);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
        function showImagePreview(imageSrc, storyCode) {
            const oldPreview = document.querySelector('.image-preview-' + storyCode);
            if (oldPreview) oldPreview.remove();
            const preview = document.createElement('div');
            preview.className = 'image-preview image-preview-' + storyCode;
            preview.style.marginTop = '10px';
            preview.id = 'image-preview-' + storyCode;
            preview.style.textAlign = 'center';
            const img = document.createElement('img');
            img.src = imageSrc;
            img.style.height = '80px';
            img.style.borderRadius = '8px';
            img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
            const delimg = document.createElement('button');
            delimg.className = 'bcloimcom blcloimcom' + storyCode;
            delimg.id = 'bcloimcom' + storyCode;
            delimg.innerHTML = `&times;`;
            delimg.style.cursor = 'pointer';
            delimg.addEventListener('click', () => preview.remove());
            preview.appendChild(img);
            preview.appendChild(delimg);
            const input = document.getElementById('inpcom-' + storyCode);
            input.value = "";
            const clearBtn = document.getElementById(`balinpcom-${storyCode}`);
            clearBtn.classList.add('hidden');
            const sendBtn = document.getElementById('sendcom-' + storyCode);
            sendBtn.parentNode.insertBefore(preview, sendBtn);
        }
    </script><!-- chat awal preview send file -->
    <script>
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('reaksi-btn2')) {
                const reaksi2 = e.target.getAttribute('data-reaksi2');
                const storyId2 = e.target.getAttribute('data-artiestoriesid2');
                if (reaksi2 && storyId2) {
                    fetch("{{ route('uprcm1') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reaksi: reaksi2,
                            commentartiestoriesid: storyId2
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                            return;
                        }
                        if (data.csrf) {
                            document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                        }
                    })
                }
            }
        });
    </script><!-- fetch reacted base content -->
    <script>
        if (typeof window.currentUserId1 === 'undefined') {
            window.currentUserId1 = {{ session('userid') }};
        }
    </script><!-- check user is logged? -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openCommentarist = @json(isset($open_commentarist) ? $open_commentarist : null);

            if (openCommentarist) {
                const modal = document.getElementById("commentarist-" + openCommentarist);
                if (modal) {
                    document.body.classList.add('noscroll');
                }
            }
        });
    </script><!-- script no scroll body -->
    <script>
        document.addEventListener('click', function (z) {
            const target = z.target;
            if (target && target.classList.value.includes('balaskansaja-')) {
                const classes = [...target.classList];
                const className = classes.find(cls => cls.startsWith('balaskansaja-'));
                const rcmId = className?.split('balaskansaja-')[1];
                if (rcmId) {
                    document.querySelector(`.lagi-${rcmId}`)?.classList.remove('hidden');
                    document.querySelector(`.balaskansaja-${rcmId}`)?.classList.add('hidden');
                    document.querySelector(`.urungkansaja-${rcmId}`)?.classList.remove('hidden');
                }
            }
            if (target && target.classList.value.includes('urungkansaja-')) {
                const classes = [...target.classList];
                const className = classes.find(cls => cls.startsWith('urungkansaja-'));
                const rcmId = className?.split('urungkansaja-')[1];
                if (rcmId) {
                    document.querySelector(`.lagi-${rcmId}`)?.classList.add('hidden');
                    document.querySelector(`.balaskansaja-${rcmId}`)?.classList.remove('hidden');
                    document.querySelector(`.urungkansaja-${rcmId}`)?.classList.add('hidden');
                    const input = document.querySelector(`.inpbalassaja-${rcmId}`);
                    if (input) input.value = "";
                }
            }
            if (target && target.classList.value.includes('close-dibales-')) {
                const classes = [...target.classList];
                const className = classes.find(cls => cls.startsWith('close-dibales-'));
                const rcmId = className?.split('close-dibales-')[1];
                if (rcmId) {
                    const input = document.querySelector(`.inpbalassaja-${rcmId}`);
                    if (input) input.value = "";
                }
            }
        });
    </script><!-- script open close chat balas comment(first time) -->
    <script>
        document.addEventListener('click', function (v) {
            const target = v.target;
            if (target && target.id.startsWith('seerpl11-')) {
                const idSuffix = target.id.substring('seerpl11-'.length);
                const seerpl2 = document.getElementById('seerpl2-' + idSuffix);
                const seerpl01 = document.getElementById('seerpl01-' + idSuffix);
                const seerpl11 = document.getElementById('seerpl11-' + idSuffix);
                if (seerpl2 && seerpl01 && seerpl11) {
                    seerpl2.classList.remove('hidden');
                    seerpl11.classList.add('hidden');
                    seerpl01.classList.remove('hidden');
                }
            }
            if (target && target.id.startsWith('seerpl01-')) {
                const idSuffix = target.id.substring('seerpl01-'.length);
                const seerpl2 = document.getElementById('seerpl2-' + idSuffix);
                const seerpl01 = document.getElementById('seerpl01-' + idSuffix);
                const seerpl11 = document.getElementById('seerpl11-' + idSuffix);
                if (seerpl2 && seerpl01 && seerpl11) {
                    seerpl2.classList.add('hidden');
                    seerpl11.classList.remove('hidden');
                    seerpl01.classList.add('hidden');
                }
            }
        });
    </script><!-- script open close chat balas comment(when have atleast 1 chat balas comment ) -->
    @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>