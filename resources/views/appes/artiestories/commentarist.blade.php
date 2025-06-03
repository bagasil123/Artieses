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
        document.querySelectorAll('[id^="inpcom-"]').forEach(inputEl => {
            const storyCode = inputEl.id.replace('inpcom-', '');
            const clearBtn = document.getElementById(`balinpcom-${storyCode}`);
            const sendBtn = document.getElementById(`sendcom-${storyCode}`);
            const commentses = document.getElementById(`commentses-${storyCode}`);
            let canSend = true;
            window.typingTimeout2 = null;
            window.canFetchTyping2 = true;
            window.typingTimeout5 = null;
            window.canFetchTyping5 = true;
            if (!commentses) return;
            inputEl.addEventListener('input', function () {
                if (inputEl.value.length > 0) {
                    clearBtn?.classList.remove('hidden');
                    clearBtn?.classList.add('block');
                } else {
                    clearBtn?.classList.add('hidden');
                    clearBtn?.classList.remove('block');
                }
                const message = inputEl.value.trim();
                const comentses = commentses.value.trim();
                if (window.canFetchTyping5) {
                    window.canFetchTyping5 = false;
                    fetch('/broadcast-typing', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message, comentses })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    });
                    clearTimeout(window.typingTimeout5);
                    window.typingTimeout5 = setTimeout(() => {
                        window.canFetchTyping5 = true;
                    }, 1000);
                }
            });
            clearBtn?.addEventListener('click', function () {
                inputEl.value = "";
                clearBtn.classList.add('hidden');
            });
            function sendComment() {
                const message = inputEl.value.trim();
                const coderies = commentses.value.trim();
                const fileInput = document.getElementById(`filepicker-${storyCode}`);
                if (message.length === 0 && canSend && fileInput.files.length > 0) {
                    canSend = false;
                    if (window.canFetchTyping2) {
                        window.canFetchTyping2 = false;
                        const formData = new FormData();
                        formData.append('coderies', coderies);
                        formData.append('fileInput', fileInput.files[0]);
                        fetch('/enter-typing', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            fileInput.value = '';
                            const delprev = document.getElementById('image-preview-' + storyCode);
                            delprev.remove();
                            clearBtn?.classList.add('hidden');
                            if (!data.logged_in) {
                                sessionStorage.setItem('alert', data.alert);
                                sessionStorage.setItem('form', data.form);
                                window.location.href = data.redirect;
                            }
                        })
                        .finally(() => {
                            setTimeout(() => {
                                canSend = true;
                            }, 30);
                        });
                        clearTimeout(window.typingTimeout2);
                        window.typingTimeout2 = setTimeout(() => {
                            window.canFetchTyping2 = true;
                        }, 1000);
                    }
                }
                if (message.length > 0 && canSend && fileInput.files.length === 0) {
                    canSend = false;
                    if (window.canFetchTyping2) {
                        window.canFetchTyping2 = false;
                        fetch('/enter-typing', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ message, coderies })
                        })
                        .then(res => res.json())
                        .then(data => {
                            inputEl.value = '';
                            clearBtn?.classList.add('hidden');
                            if (!data.logged_in) {
                                sessionStorage.setItem('alert', data.alert);
                                sessionStorage.setItem('form', data.form);
                                window.location.href = data.redirect;
                            }
                        })
                        .finally(() => {
                            setTimeout(() => {
                                canSend = true;
                            }, 30);
                        });
                        clearTimeout(window.typingTimeout2);
                        window.typingTimeout2 = setTimeout(() => {
                            window.canFetchTyping2 = true;
                        }, 1000);
                    }
                }
            }
            inputEl.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    sendComment();
                }
            });
            sendBtn?.addEventListener('click', function (event) {
                event.preventDefault();
                sendComment();
            });
        });
    </script><!-- fetch broadcasting dan chat awal comment -->
    <script>
        if (typeof window.pusher === 'undefined') {
            Pusher.logToConsole = true;
            window.pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: true
            });
        }
        if (typeof window.channel === 'undefined') {
            window.channel = window.pusher.subscribe('typing-channel');
        }
        if (typeof window.channel1 === 'undefined') {
            window.channel1 = window.pusher.subscribe('broadcast-channel');
        }
        if (!window.channelBound1) {
            window.channel.bind('user.typing', function (data) {
                if (data.message && data.message !== "") {
                    const targetWrapper = document.querySelector(`.commentarist[data-story="${data.coderies}"]`);
                    check1 = targetWrapper.getAttribute('data-story');
                    if (data.coderies === check1) {
                        const container = document.getElementById(`wrappercom1-${check1}`);
                        const commentwrapcom001 = document.createElement('div');
                        const apusnoncmt = document.getElementById(`noncomments-${data.coderies}`)
                        if (apusnoncmt){
                            apusnoncmt.remove();
                        }
                        const aharen = document.createElement('a')
                        aharen.href = `/profiles/${data.username}`;
                        const aharen1 = document.createElement('a')
                        aharen1.href = `/profiles/${data.username}`;
                        commentwrapcom001.id = `commentwrapcom-${data.comstoriesid}`;
                        const card = document.createElement('div');
                        card.className = `cardcom001 cardcom001-${data.comstoriesid}`;
                        const img = document.createElement('img');
                        img.src = `${data.username}/profil/${data.improfil}`;
                        img.className = 'creatorstories';
                        const dispcard = document.createElement('div');
                        dispcard.className = 'dispcard';
                        const ddispcanam = document.createElement('div');
                        ddispcanam.className = 'ddispcanam';
                        const pName = document.createElement('p');
                        pName.className = 'dispname';
                        pName.innerText = data.username;
                        ddispcanam.appendChild(aharen1);
                        aharen1.appendChild(pName);
                        const pComment = document.createElement('p');
                        pComment.className = 'comment001';
                        const tempDiv = document.createElement("div");
                        tempDiv.innerHTML = data.message;
                        const imgElement = tempDiv.querySelector('img.imgcom');
                        if (imgElement) {
                            pComment.innerHTML = data.message;
                        } else {
                            pComment.innerText = tempDiv.innerText;
                        }
                        const wrappercom2 = document.createElement('div');
                        wrappercom2.className = `wrappercom2 wrappercom2-${data.coderies}`;
                        const reacted3 = document.createElement('div');
                        reacted3.className = `srcard3 srcard3-${data.comstoriesid} hidden`;
                        reacted3.id = `srcard3-${data.comstoriesid}`;
                        const reacted31 = document.createElement('a');
                        reacted31.href = `javascript:void(0)`;
                        const reacted32 = document.createElement('a');
                        reacted32.href = `javascript:void(0)`;
                        const reacted33 = document.createElement('a');
                        reacted33.href = `javascript:void(0)`;
                        const reacted34 = document.createElement('a');
                        reacted34.href = `javascript:void(0)`;
                        const reacted35 = document.createElement('a');
                        reacted35.href = `javascript:void(0)`;
                        const img31 = document.createElement('img');
                        img31.src = '{{ asset('partses/reaksi/suka.png') }}';
                        img31.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                        img31.setAttribute('data-reaksi2', 'suka');
                        img31.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                        const img32 = document.createElement('img');
                        img32.src = '{{ asset('partses/reaksi/senang.png') }}';
                        img32.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                        img32.setAttribute('data-reaksi2', 'senang');
                        img32.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                        const img33 = document.createElement('img');
                        img33.src = '{{ asset('partses/reaksi/ketawa.png') }}';
                        img33.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                        img33.setAttribute('data-reaksi2', 'ketawa');
                        img33.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                        const img34 = document.createElement('img');
                        img34.src = '{{ asset('partses/reaksi/sedih.png') }}';
                        img34.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                        img34.setAttribute('data-reaksi2', 'sedih');
                        img34.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                        const img35 = document.createElement('img');
                        img35.src = '{{ asset('partses/reaksi/marah.png') }}';
                        img35.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                        img35.setAttribute('data-reaksi2', 'marah');
                        img35.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                        const iclikeswrap = document.createElement('div')
                        iclikeswrap.className = `iclikeswrap rbtnry3-${data.comstoriesid}`;
                        iclikeswrap.id = `rbtnry3-${data.comstoriesid}`;
                        const suka = document.createElement('p');
                        suka.className = `inint rbtnry3-${data.comstoriesid}`;
                        suka.id = `rbtnry3-${data.comstoriesid}`;
                        suka.innerText = 'suka';
                        const created = document.createElement('p');
                        created.className = 'captionStoriess gg12';
                        created.innerText = `${data.timeAgo}`;
                        const balaskan001 = document.createElement('div');
                        balaskan001.className = `balaskan001`;
                        balaskan001.id = `balaskan001-${data.comstoriesid}`;
                        const balaskan = document.createElement('p');
                        balaskan.className = `balaskan002 balaskansaja-${data.comstoriesid}`;
                        balaskan.id = `balaskansaja-${data.comstoriesid}`;
                        balaskan.innerText = 'Balas';
                        const urungkansaja = document.createElement('p');
                        urungkansaja.className = `urungkan001 urungkansaja-${data.comstoriesid} hidden`;
                        urungkansaja.id = `urungkansaja-${data.comstoriesid}`;
                        urungkansaja.innerText = 'Urungkan';
                        const dibaleslagi = document.createElement('div');
                        dibaleslagi.className = `dibales lagi-${data.comstoriesid} hidden`;
                        dibaleslagi.id = `lagi-${data.comstoriesid}`;
                        const inpbalassaja = document.createElement('input');
                        inpbalassaja.type = `text`;
                        inpbalassaja.className = `inpbalassaja inpbalassaja-${data.comstoriesid}`;
                        inpbalassaja.id = `inpbalassaja-${data.comstoriesid}`;
                        inpbalassaja.setAttribute('placeholder', 'Kirim komentar...');
                        inpbalassaja.required = true;
                        const inpbalassajahidden = document.createElement('input');
                        inpbalassajahidden.type = `hidden`;
                        inpbalassajahidden.value = data.comstoriesid;
                        inpbalassajahidden.id = `inpbalassajahidden-${data.comstoriesid}`;
                        const closeDibales = document.createElement('button');
                        closeDibales.type = `button`;
                        closeDibales.className = `close-dibales close-dibales-${data.comstoriesid}`;
                        closeDibales.id = `close-dibales-${data.comstoriesid}`;
                        closeDibales.innerHTML = '&times;';
                        const submitDibales = document.createElement('button');
                        submitDibales.type = `submit`;
                        submitDibales.className = `btnimg-sendcom btnimg-sendcom-${data.comstoriesid}`;
                        submitDibales.id = `btnimg-sendcom-${data.comstoriesid}`;
                        const dibalesIMG = document.createElement('img');
                        dibalesIMG.className = `iclikescmt1`;
                        dibalesIMG.src = `{{ asset('partses/sendcomdm.png') }}`;
                        const scriptReact = document.createElement('script');
                        const brort = document.createElement('div');
                        brort.className = `brcmt2 hidden`;
                        brort.id = `divbrcmt2-${data.comstoriesid}`;
                        const brortp = document.createElement('p');
                        brortp.id = `brcmt2-${data.comstoriesid}`;
                        const imgupload = document.createElement('img');
                        imgupload.src = `{{ asset('partses/import.png') }}`;
                        imgupload.className = `iclikestoryimp1`;
                        imgupload.id = `iclikestoryimp1-${data.comstoriesid}`;
                        const inpfile = document.createElement('input');
                        inpfile.type = `file`;
                        inpfile.setAttribute('accept', 'image/*');
                        inpfile.id = `filepicker1-${data.comstoriesid}`;
                        inpfile.className = `hidden`;
                        container.appendChild(commentwrapcom001);
                        commentwrapcom001.append(card, wrappercom2);
                        card.append(aharen, dispcard);
                        aharen.appendChild(img);
                        dispcard.append(ddispcanam, pComment);
                        wrappercom2.append(balaskan001, dibaleslagi);
                        balaskan001.append(reacted3, suka, scriptReact, balaskan, urungkansaja, created);
                        reacted3.append(reacted31, reacted32, reacted33, reacted34, reacted35);
                        reacted31.appendChild(img31);
                        reacted32.appendChild(img32);
                        reacted33.appendChild(img33);
                        reacted34.appendChild(img34);
                        reacted35.appendChild(img35);
                        dibaleslagi.append(brort, imgupload, inpfile, inpbalassaja, closeDibales, inpbalassajahidden, submitDibales);
                        brort.appendChild(brortp);
                        submitDibales.appendChild(dibalesIMG);
                        scriptReact.textContent = `
                            document.querySelectorAll('.rbtnry3-${data.comstoriesid}').forEach(function (button) {
                                button.addEventListener('mouseenter', function () {
                                    const button3 = document.getElementById('rbtnry3-${data.comstoriesid}');
                                    const srcard3 = document.getElementById('srcard3-${data.comstoriesid}');
                                    srcard3.classList.remove('hidden');
                                });
                                button.addEventListener('mouseleave', function () {
                                    const button3 = document.getElementById('rbtnry3-${data.comstoriesid}');
                                    const srcard3 = document.getElementById('srcard3-${data.comstoriesid}');
                                    setTimeout(() => {
                                        if (!srcard3.matches(':hover')) {
                                            srcard3.classList.add('hidden');
                                        }}, 0);
                                });
                            });
                        `;
                    }
                }
            });
            window.channelBound1 = true;
        };
        window.channel1.bind('broadcast.typing', function (data) {
            if (data.reqplat && data.reqplat.length > 0) {
            if (data.reqplat == '{{ $storyCode }}') {
                const cardmengetik = document.getElementById('divbrcmt-{{ $storyCode }}');
                const teksmengetik = document.getElementById('brcmt-{{ $storyCode }}');
                cardmengetik.classList.remove('hidden');
                teksmengetik.innerText = `${data.username} sedang mengetik...`;
                clearTimeout(window.typingTimeout);
                window.typingTimeout = setTimeout(() => {
                    teksmengetik.innerText = '';
                    cardmengetik.classList.add('hidden');
                }, 2000);
            }}
        });
    </script><!-- pusher broadcasting dan chat awal comment -->
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
        if (typeof window.pusher1 === 'undefined') {
            window.pusher1 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: true
            });
        }
        if (typeof window.channel3 === 'undefined') {
            window.channel3 = window.pusher1.subscribe('typing-channel1');
        }
        window.typingTimeout3 = null;
        window.canFetchTyping3 = true;
        window.channel3.bind('user.typing1', function (data) {
            if (data.message && data.message !== "") {
                if (window.canFetchTyping3) {
                    window.canFetchTyping3 = false;
                    const cekseerpl2 = document.getElementById(`seerpl2-${data.comstoriesid}`);
                    const reply = document.createElement('div');
                    reply.className = `reply reply-${data.comstoriesid}`;
                    const aprofil = document.createElement('a');
                    aprofil.href = `/profiles/${data.username}`;
                    const imgprofil = document.createElement('img');
                    imgprofil.src = `${data.username}/profil/${data.improfil}`;
                    imgprofil.className = `creatorstories`;
                    const dispcard = document.createElement('div');
                    dispcard.className = 'dispcard';
                    const aname = document.createElement('a');
                    aname.href = `/profiles/${data.username}`;
                    const nameprofil = document.createElement('p');
                    nameprofil.className = `dispname`;
                    nameprofil.innerText = data.username;
                    const messageprof = document.createElement('p');
                    messageprof.className = `comment001`;
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = data.message;
                    const imgElement = tempDiv.querySelector('img.imgcom');
                    if (imgElement) {
                        messageprof.innerHTML = data.message;
                    } else {
                        messageprof.innerText = tempDiv.innerText;
                    }
                    const wrappercom3 = document.createElement('div');
                    wrappercom3.className = `wrappercom3 wrappercom3-${data.comstoriesid}`;
                    const reacted = document.createElement('div');
                    reacted.className = `srcard4 srcard5-${data.comstoriesid} hidden`;
                    reacted.id = `srcard5-${data.comstoriesid}`;
                    const reacted1 = document.createElement('a');
                    reacted1.href = `javascript:void(0)`;
                    const reacted2 = document.createElement('a');
                    reacted2.href = `javascript:void(0)`;
                    const reacted3 = document.createElement('a');
                    reacted3.href = `javascript:void(0)`;
                    const reacted4 = document.createElement('a');
                    reacted4.href = `javascript:void(0)`;
                    const reacted5 = document.createElement('a');
                    reacted5.href = `javascript:void(0)`;
                    const reactedimg1 = document.createElement('img');
                    reactedimg1.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg1.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                    reactedimg1.setAttribute('data-reaksi4', 'suka');
                    reactedimg1.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                    const reactedimg2 = document.createElement('img');
                    reactedimg2.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg2.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                    reactedimg2.setAttribute('data-reaksi4', 'suka');
                    reactedimg2.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                    const reactedimg3 = document.createElement('img');
                    reactedimg3.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg3.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                    reactedimg3.setAttribute('data-reaksi4', 'suka');
                    reactedimg3.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                    const reactedimg4 = document.createElement('img');
                    reactedimg4.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg4.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                    reactedimg4.setAttribute('data-reaksi4', 'suka');
                    reactedimg4.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                    const reactedimg5 = document.createElement('img');
                    reactedimg5.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg5.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                    reactedimg5.setAttribute('data-reaksi4', 'suka');
                    reactedimg5.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                    const reactedp = document.createElement('p');
                    reactedp.className = `rbtnry5-${data.comstoriesid}`;
                    reactedp.id = `rbtnry5-${data.comstoriesid}`;
                    reactedp.innerText = 'suka';
                    const createdate = document.createElement('p');
                    createdate.className = `captionStoriess gg2`;
                    createdate.innerHTML = `${data.timeAgo}`;
                    const getChat = document.getElementById(`lagi-${data.reqplat}`);
                    const balas = document.getElementById(`seerpl11-${data.reqplat}`);
                    const urungkan = document.getElementById(`seerpl01-${data.reqplat}`);
                    if (!balas) {
                        const balas1 = document.getElementById(`balaskansaja-${data.reqplat}`);
                        const urungkan1 = document.getElementById(`urungkansaja-${data.reqplat}`);
                        if (urungkan1) urungkan1.remove();
                        if (balas1) balas1.remove();
                        const replies = document.createElement('div');
                        replies.className = `replies replies-${data.comstoriesid}`;
                        replies.id = `seerpl2-${data.comstoriesid}`;
                        const makebalaskan = document.createElement('p');
                        makebalaskan.className = `balaskan002`;
                        makebalaskan.id = `seerpl11-${data.comstoriesid}`;
                        makebalaskan.innerHTML = `Lihat(${data.jumlah})`;
                        const makeurungkan = document.createElement('p');
                        makeurungkan.className = `urungkan001`;
                        makeurungkan.id = `seerpl01-${data.comstoriesid}`;
                        makeurungkan.innerHTML = `Tutup(${data.jumlah})`;
                        const wrappercom2 = document.getElementById(`wrappercom2-${data.reqplat}`);
                        wrappercom2.appendChild(replies);
                        replies.append(reply, wrappercom3, getChat);
                        const getsuka = document.getElementById(`rbtnry3-${data.reqplat}`);
                        if (getsuka) getsuka.after(makebalaskan);
                        makebalaskan.after(makeurungkan);
                        if (data.userid === currentUserId1) {
                            makebalaskan.classList.add('hidden');
                        } else {
                            makeurungkan.classList.add('hidden');
                            replies.classList.add('hidden')
                        }
                    } if (balas) {
                        balas.innerHTML = `Lihat(${data.jumlah})`;
                        urungkan.innerHTML = `Tutup(${data.jumlah})`;
                        const getreplies = document.getElementById(`seerpl2-${data.reqplat}`);
                        getreplies.append(reply, wrappercom3, getChat);
                    };
                    reply.append(aprofil, dispcard);
                    aprofil.appendChild(imgprofil);
                    dispcard.append(aname,messageprof);
                    aname.appendChild(nameprofil);
                    wrappercom3.append(reacted, reactedp, createdate);
                    reacted.append(reacted1, reacted2, reacted3, reacted4, reacted5);
                    reacted1.appendChild(reactedimg1);
                    reacted2.appendChild(reactedimg2);
                    reacted3.appendChild(reactedimg3);
                    reacted4.appendChild(reactedimg4);
                    reacted5.appendChild(reactedimg5);
                    clearTimeout(window.typingTimeout3);
                    window.typingTimeout3 = setTimeout(() => {
                        window.canFetchTyping3 = true;
                    }, 1000);
                }
            }
        });
        if (typeof window.channel4 === 'undefined') {
            window.channel4 = window.pusher1.subscribe('broadcast-channel1');
        }
        window.channel4.bind('broadcast.typing1', function (data) {
            if (data.reqplat && data.reqplat.length > 0) {
                const cardmengetik = document.getElementById(`divbrcmt2-${data.reqplat}`);
                const teksmengetik = document.getElementById(`brcmt2-${data.reqplat}`);
                cardmengetik.classList.remove('hidden');
                teksmengetik.innerText = `${data.username} sedang mengetik...`;
                clearTimeout(window.typingTimeouts?.[data.reqplat]);
                window.typingTimeouts = window.typingTimeouts || {};
                window.typingTimeouts[data.reqplat] = setTimeout(() => {
                    teksmengetik.innerText = '';
                    cardmengetik.classList.add('hidden');
                }, 4000);
            }
        });
    </script><!-- pusher broadcasting dan chat balas comment -->
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
        document.querySelectorAll('[id^="inpbalassaja-"]').forEach(inputOL => {
            const targetid = inputOL.id.replace('inpbalassaja-', '');
            const clearBtn1 = document.getElementById(`close-dibales-${targetid}`);
            const sendBtn1 = document.getElementById(`btnimg-sendcom-${targetid}`);
            const commentses1 = document.getElementById(`inpbalassajahidden-${targetid}`);
            let canSend1 = true;
            window.typingTimeout1 = null;
            window.canFetchTyping1 = true;
            window.typingTimeout = null;
            window.canFetchTyping = true;
            inputOL.addEventListener('input', function () {
                if (inputOL.value.length > 0) {
                    clearBtn1?.classList.remove('hidden');
                    clearBtn1?.classList.add('block');
                } else {
                    clearBtn1?.classList.add('hidden');
                    clearBtn1?.classList.remove('block');
                }
                const message1 = inputOL.value.trim();
                const comentses1 = commentses1.value.trim();
                if (window.canFetchTyping) {
                    window.canFetchTyping = false;
                    fetch('/broadcast-typing1', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message1, comentses1 })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    });
                    clearTimeout(window.typingTimeout5);
                    window.typingTimeout5 = setTimeout(() => {
                        window.canFetchTyping5 = true;
                    }, 1000);
                }
            });
            clearBtn1?.addEventListener('click', function () {
                inputOL.value = "";
                clearBtn1.classList.add('hidden');
            });
            function sendComment1() {
                const message1 = inputOL.value.trim();
                const storyCode1 = commentses1.value.trim();
                const code = " {{ $storyCode }}";
                const fileInput1 = document.getElementById(`filepicker1-${targetid}`);
                if (message1.length === 0 && canSend1 && fileInput1.files.length > 0) {
                    canSend1 = false;
                    if (window.canFetchTyping1) {
                        window.canFetchTyping1 = false;
                        const formData = new FormData();
                        formData.append('storyCode1', storyCode1);
                        formData.append('code', code);
                        formData.append('fileInput1', fileInput1.files[0]);
                        fetch('/enter-typing1', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            fileInput1.value = '';
                            const delprev1 = document.getElementById('image-preview1-' + targetid);
                            delprev1.remove();
                            console.log(data.message);
                            clearBtn1?.classList.add('hidden');
                            if (!data.logged_in) {
                                sessionStorage.setItem('alert', data.alert);
                                sessionStorage.setItem('form', data.form);
                                window.location.href = data.redirect;
                            }
                        })
                        .finally(() => {
                            setTimeout(() => {
                                canSend1 = true;
                            }, 30);
                        });
                        clearTimeout(window.typingTimeout1);
                        window.typingTimeout1 = setTimeout(() => {
                            window.canFetchTyping1 = true;
                        }, 1000);
                    }
                }
                if (message1.length > 0 && canSend1 && fileInput1.files.length === 0) {
                    canSend1 = false;
                    if (window.canFetchTyping1) {
                        window.canFetchTyping1 = false;
                        fetch('/enter-typing1', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ message1, storyCode1 })
                        })
                        .then(res => res.json())
                        .then(data => {
                            inputOL.value = '';
                            clearBtn1?.classList.add('hidden');
                            if (!data.logged_in) {
                                sessionStorage.setItem('alert', data.alert);
                                sessionStorage.setItem('form', data.form);
                                window.location.href = data.redirect;
                            }
                        })
                        .finally(() => {
                            setTimeout(() => {
                                canSend1 = true;
                            }, 30);
                        });
                        clearTimeout(window.typingTimeout1);
                        window.typingTimeout1 = setTimeout(() => {
                            window.canFetchTyping1 = true;
                        }, 1000);
                    }
                }
            }
            inputOL.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    sendComment1();
                }
            });
            sendBtn1?.addEventListener('click', function (event) {
                event.preventDefault();
                sendComment1();
            });
        });
    </script><!-- fetch broadcasting dan chat balas comment -->
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
    <script>
        document.querySelectorAll('[id^="importbtn1-"]').forEach(importBtn1 => {
            const storyCode1 = importBtn1.id.replace('importbtn1-', '');
            const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
            if (fileInput1) {
                importBtn1.addEventListener('click', () => {
                    fileInput1.click();
                });
            }
            if (fileInput1 && !fileInput1.dataset.listenerAdded) {
                fileInput1.addEventListener('change', function () {
                    const file1 = this.files[0];
                    if (file1 && file1.type.startsWith('image/')) {
                        const reader1 = new FileReader();
                        reader1.onload = function (event) {
                            showImagePreview1(event.target.result, storyCode1);
                        };
                        reader1.readAsDataURL(file1);
                    }
                });
                fileInput1.dataset.listenerAdded = 'true';
            }
            const input1 = document.getElementById('inpbalassaja-' + storyCode1);
            if (input1 && !input1.dataset.listenerAdded) {
                input1.addEventListener('paste', function (e) {
                    const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                    for (let i = 0; i < items.length; i++) {
                        if (items[i].type.indexOf("image") === 0) {
                            const file = items[i].getAsFile();
                            const reader1 = new FileReader();
                            reader1.onload = function (event) {
                                showImagePreview1(event.target.result, storyCode1);
                            };
                            reader1.readAsDataURL(file);
                        }
                    }
                });
                input1.dataset.listenerAdded = 'true';
            }
        });
        function showImagePreview1(imageSrc, storyCode1) {
            const oldPreview = document.querySelector('.image-preview1-' + storyCode1);
            if (oldPreview) oldPreview.remove();
            const preview = document.createElement('div');
            preview.className = 'image-preview1 image-preview1-' + storyCode1;
            preview.style.marginTop = '10px';
            preview.id = 'image-preview1-' + storyCode1;
            preview.style.textAlign = 'center';
            const img = document.createElement('img');
            img.src = imageSrc;
            img.style.height = '80px';
            img.style.borderRadius = '8px';
            img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
            const delimg = document.createElement('button');
            delimg.className = 'bcloimcom1 blcloimcom' + storyCode1;
            delimg.id = 'bcloimcom' + storyCode1;
            delimg.innerHTML = '&times;';
            delimg.style.cursor = 'pointer';
            delimg.addEventListener('click', () => preview.remove());
            preview.appendChild(img);
            preview.appendChild(delimg);
            const input1 = document.getElementById('inpbalassaja-' + storyCode1);
            if (input1) input1.value = "";
            const clearBtn1 = document.getElementById(`close-dibales-${storyCode1}`);
            if (clearBtn1) clearBtn1.classList.add('hidden');
            const sendBtn = document.getElementById('lagi-' + storyCode1);
            if (sendBtn && sendBtn.parentNode) {
                sendBtn.parentNode.insertBefore(preview, sendBtn);
            }
        }
    </script><!-- preview img balascomment -->
    @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>