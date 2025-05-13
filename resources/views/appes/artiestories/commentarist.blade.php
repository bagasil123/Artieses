@php 
    $storyCode = $story->coderies;
@endphp
<div id="commentarist-{{ $storyCode }}" class="commentarist commentarist-{{ $storyCode }} {{ isset($open_commentarist) && $open_commentarist == $storyCode ? 'block' : 'hidden' }} {{ isset($open_commentarist) == $storyCode ? 'block' : 'hidden' }}" data-story="{{ $storyCode }}">
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
    <div class="brcmt hidden" id="divbrcmt-{{ $storyCode }}">
        <p id="brcmt-{{ $storyCode }}"></p>
    </div>
        <div class="chat chat-{{ $storyCode }}">
            <input type="text" class="inpcom inpcom-{{ $storyCode }}" id="inpcom-{{ $storyCode }}" placeholder="Kirim komentar..." required/>
            <input type="hidden" value="{{ $storyCode }}" id="commentses-{{ $storyCode }}">
            <input type="hidden" value="{{ $storyCode }}" id="commentses1-{{ $storyCode }}">
            <button type="button" class="balinpcom balinpcom-{{ $storyCode }} hidden" id="balinpcom-{{ $storyCode }}">&times;</button>
            <button type="submit" class="sendcom sendcom-{{ $storyCode }}" id="sendcom-{{ $storyCode }}">
                <img class="iclikestory" loading="lazy" src="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>      
        <script>
            document.querySelectorAll('.inpcom-{{ $storyCode }}').forEach(inputEl => {
                const storyCode = inputEl.id.replace('inpcom-', '');
                const clearBtn = document.getElementById(`balinpcom-{{ $storyCode }}`)
                if (clearBtn) {
                    inputEl.addEventListener('input', function () {
                        if (inputEl.value.length > 0) {
                            clearBtn.classList.remove('hidden');
                            clearBtn.classList.add('block');
                        } else {
                            clearBtn.classList.add('hidden');
                            clearBtn.classList.remove('block');
                        }
                    });
                    clearBtn.addEventListener('click', function () {
                        inputEl.value = "";
                        clearBtn.classList.add('hidden');
                    });
                    let canSend = true;
                    inputEl.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter' && canSend) {
                            event.preventDefault();
                            const message = inputEl.value.trim();
                            const commentses = document.getElementById('commentses-{{ $storyCode }}');
                            const coderies = commentses.value.trim();
                            if (message.length > 0) {
                                canSend = false; 
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
                                    clearBtn.classList.add('hidden');
                                })
                                .finally(() => {
                                    setTimeout(() => {
                                        canSend = true;
                                    }, 3000);
                                });
                            }
                        }
                    });
                    let typingTimeout;
                    let lastBroadcast = 0;
                    inputEl.addEventListener('input', function () {
                        const now = Date.now();
                        if (now - lastBroadcast < 1000) return; 
                        lastBroadcast = now;
                        const message = inputEl.value.trim();
                        const commentses = document.getElementById('commentses-{{ $storyCode }}');
                        const comentses = commentses.value.trim();
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
                        });
                    });
                }
            });
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
                            commentwrapcom001.id = `commentwrapcom-${data.comstoriesid}`;
                            const card = document.createElement('div');
                            card.className = 'cardcom001';
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
                            ddispcanam.appendChild(pName);
                            const pComment = document.createElement('p');
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
                            created.className = 'captionStories gg1';
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
                            pComment.className = 'comment001';
                            pComment.innerText = data.message;
                            const dibaleslagi = document.createElement('div');
                            dibaleslagi.className = `dibales lagi-${data.comstoriesid} hidden`;
                            dibaleslagi.id = `lagi-${data.comstoriesid}`;
                            const inpbalassaja = document.createElement('input');
                            inpbalassaja.type = `text`;
                            inpbalassaja.className = `inpbalassaja-${data.comstoriesid}`;
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
                            closeDibales.innerHTML = '&times;';
                            const submitDibales = document.createElement('button');
                            submitDibales.type = `submit`;
                            submitDibales.className = `btnimg-sendcom btnimg-sendcom-${data.comstoriesid}`;
                            const dibalesIMG = document.createElement('img');
                            dibalesIMG.className = `iclikescmt`;
                            dibalesIMG.src = `{{ asset('partses/sendcomdm.png') }}`;
                            const scriptReact = document.createElement('script');
                            const script = document.createElement('script');
                            const brort = document.createElement('div');
                            brort.className = `brcmt2 hidden`;
                            brort.id = `divbrcmt2-${data.comstoriesid}`;
                            const brortp = document.createElement('p');
                            brortp.id = `brcmt2-${data.comstoriesid}`;
                            container.appendChild(commentwrapcom001);
                            commentwrapcom001.append(card, wrappercom2, balaskan001, dibaleslagi);
                            card.append(img, dispcard);
                            dispcard.append(ddispcanam, pComment);
                            wrappercom2.append(reacted3, suka, scriptReact, created);
                            reacted3.append(reacted31, reacted32, reacted33, reacted34, reacted35);
                            reacted31.appendChild(img31);
                            reacted32.appendChild(img32);
                            reacted33.appendChild(img33);
                            reacted34.appendChild(img34);
                            reacted35.appendChild(img35);
                            balaskan001.append(balaskan, urungkansaja);
                            dibaleslagi.append(brort, inpbalassaja, closeDibales, inpbalassajahidden, submitDibales, script);
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
                            script.textContent = `
                                document.querySelectorAll('.balaskansaja-${data.comstoriesid}').forEach(function (button) {
                                    button.addEventListener('click', function () {
                                        const balaskanlagi = document.querySelector('.lagi-${data.comstoriesid}');
                                        const balaskansaja = document.querySelector('.balaskansaja-${data.comstoriesid}');
                                        const urungkansaja = document.querySelector('.urungkansaja-${data.comstoriesid}');
                                        balaskanlagi.classList.remove('hidden');
                                        balaskansaja.classList.add('hidden');
                                        urungkansaja.classList.remove('hidden');
                                    });
                                });
                                document.querySelectorAll('.close-dibales-${data.comstoriesid}').forEach(function (button) {
                                    button.addEventListener('click', function () {
                                        const inpbalassaja = document.querySelector('.inpbalassaja-${data.comstoriesid}');
                                        inpbalassaja.value = "";
                                    });
                                });
                                document.querySelectorAll('.urungkansaja-${data.comstoriesid}').forEach(function (button) {
                                    button.addEventListener('click', function () {
                                        const balaskanlagi = document.querySelector('.lagi-${data.comstoriesid}');
                                        const balaskansaja = document.querySelector('.balaskansaja-${data.comstoriesid}');
                                        const urungkansaja = document.querySelector('.urungkansaja-${data.comstoriesid}');
                                        const inpbalassaja = document.querySelector('.inpbalassaja-${data.comstoriesid}');
                                        inpbalassaja.value = "";
                                        balaskanlagi.classList.add('hidden');
                                        balaskansaja.classList.remove('hidden');
                                        urungkansaja.classList.add('hidden');
                                    });
                                });
                            `;
                    }}});
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
        </script>
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
        </script>
        
        <script>
            if (typeof window.currentUserId1 === 'undefined') {
                window.currentUserId1 = {{ session('userid') }};
            }
        </script>
        <script>
            document.addEventListener('keydown', function (e) {
                const target = e.target;
                if (target && target.matches('[class^="inpbalassaja-"]')) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const inputClass = [...target.classList].find(cls => cls.startsWith('inpbalassaja-'));
                        const idSuffix = inputClass.substring('inpbalassaja-'.length);

                        const commentses = document.getElementById('inpbalassajahidden-' + idSuffix);
                        const clearBtn = document.getElementById('close-dibales-' + idSuffix);

                        const message = target.value.trim();
                        const comentses = commentses.value.trim();

                        fetch('/enter-typing1', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ message, comentses })
                        })
                        .then(res => res.json())
                        .then(data => {
                            target.value = '';
                            if (clearBtn) clearBtn.classList.add('hidden');
                        });
                    }
                }
            });
        </script>
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
                if (!window.channelBound) {
                window.channel3.bind('user.typing1', function (data) {
                    if (data.message && data.message !== "") {
                        const balaskan001 = document.getElementById(`balaskan001-${data.comstoriesid}`);
                        if (document.getElementById(`balaskan001-${data.comstoriesid}`)) {
                            balaskan001.remove();
                        }
                        const dibalesin009 = document.getElementById(`lagi-${data.comstoriesid}`);
                        const commentwrapcom = document.getElementById(`commentwrapcom-${data.comstoriesid}`);
                        const view = document.createElement('p');
                        view.id = `seerpl1-${data.comstoriesid}`;
                        const view1 = document.createElement('p');
                        view1.id = `seerpl0-${data.comstoriesid}`;
                        view.innerHTML = `Lihat(${data.jumlah})`;
                        view1.innerHTML = `Tutup(${data.jumlah})`;
                        const replies = document.createElement('div');
                        if (data.userid === currentUserId1) {
                            view.className = `comment0010 hidden`;
                            view1.className = `comment00101`;
                            replies.className = `replies replies-${data.comstoriesid}`;
                            replies.id = `seerpl2-${data.comstoriesid}`;
                        } else {
                            view.className = `comment0010`;
                            view1.className = `comment00101 hidden`;
                            replies.className = `replies replies-${data.comstoriesid} hidden`;
                            replies.id = `seerpl2-${data.comstoriesid}`;
                        }
                        const reply = document.createElement('div')
                        reply.className = `reply reply-${data.comstoriesid}`;
                        const wrappercom3 = document.createElement('div');
                        wrappercom3.className = `wrappercom3 wrappercom3-${data.comstoriesid}`;
                        const imgbalcom = document.createElement('img');
                        imgbalcom.src = `${data.username}/profil/${data.improfil}`;
                        imgbalcom.className = `creatorstories`;
                        const dispcard2 = document.createElement('div');
                        dispcard2.className = `dispcard`;
                        const usernamebalcom = document.createElement('p');
                        usernamebalcom.innerText = data.username;
                        const balcomment = document.createElement('p');
                        balcomment.innerText = data.message;
                        const reactbalcom = document.createElement('p');
                        reactbalcom.className = `comment0011 rbtnry5-${data.balcomid}`;
                        reactbalcom.id = `rbtnry5-${data.balcomid}`;
                        reactbalcom.innerText = `suka`;
                        const reacted4 = document.createElement('div');
                        reacted4.className = `srcard3 srcard5-${data.balcomid} hidden`;
                        reacted4.id = `srcard5-${data.balcomid}`;
                        const reacted41 = document.createElement('a');
                        reacted41.href = `javascript:void(0)`;
                        const reacted42 = document.createElement('a');
                        reacted42.href = `javascript:void(0)`;
                        const reacted43 = document.createElement('a');
                        reacted43.href = `javascript:void(0)`;
                        const reacted44 = document.createElement('a');
                        reacted44.href = `javascript:void(0)`;
                        const reacted45 = document.createElement('a');
                        reacted45.href = `javascript:void(0)`;
                        const scriptReacted1 = document.createElement('script');
                        scriptReacted1.textContent = `
                            document.querySelectorAll('.rbtnry5-${data.balcomid}').forEach(function (button) {
                                button.addEventListener('mouseenter', function () {
                                    const button4 = document.getElementById('rbtnry5-${data.balcomid}');
                                    const srcard4 = document.getElementById('srcard5-${data.balcomid}');
                                    srcard4.classList.remove('hidden');
                                });
                                button.addEventListener('mouseleave', function () {
                                    const button4 = document.getElementById('rbtnry5-${data.balcomid}');
                                    const srcard4 = document.getElementById('srcard5-${data.balcomid}');
                                    setTimeout(() => {
                                        if (!srcard4.matches(':hover')) {
                                            srcard4.classList.add('hidden');
                                        }
                                    }, 0);
                                });
                            });
                        `;
                        const img41 = document.createElement('img');
                        img41.src = '{{ asset('partses/reaksi/suka.png') }}';
                        img41.className = `iclikestoriesemote3 reaksi-btn3 reaksi-btn3-${data.balcomid}`;
                        img41.setAttribute('data-reaksi2', 'suka');
                        img41.setAttribute('data-artiestoriesid2', `${data.balcomid}`);
                        const img42 = document.createElement('img');
                        img42.src = '{{ asset('partses/reaksi/senang.png') }}';
                        img42.className = `iclikestoriesemote3 reaksi-btn3 reaksi-btn3-${data.balcomid}`;
                        img42.setAttribute('data-reaksi2', 'senang');
                        img42.setAttribute('data-artiestoriesid2', `${data.balcomid}`);
                        const img43 = document.createElement('img');
                        img43.src = '{{ asset('partses/reaksi/ketawa.png') }}';
                        img43.className = `iclikestoriesemote3 reaksi-btn3 reaksi-btn3-${data.balcomid}`;
                        img43.setAttribute('data-reaksi2', 'ketawa');
                        img43.setAttribute('data-artiestoriesid2', `${data.balcomid}`);
                        const img44 = document.createElement('img');
                        img44.src = '{{ asset('partses/reaksi/sedih.png') }}';
                        img44.className = `iclikestoriesemote3 reaksi-btn3 reaksi-btn3-${data.balcomid}`;
                        img44.setAttribute('data-reaksi2', 'sedih');
                        img44.setAttribute('data-artiestoriesid2', `${data.balcomid}`);
                        const img45 = document.createElement('img');
                        img45.src = '{{ asset('partses/reaksi/marah.png') }}';
                        img45.className = `iclikestoriesemote3 reaksi-btn3 reaksi-btn3-${data.balcomid}`;
                        img45.setAttribute('data-reaksi2', 'marah');
                        img45.setAttribute('data-artiestoriesid2', `${data.balcomid}`);
                        const createdat = document.createElement('p');
                        createdat.className = 'captionStories gg3';
                        createdat.innerText = `${data.timeAgo}`;
                        const bukatutup = document.createElement('script');
                        bukatutup.textContent = `
                            document.querySelectorAll('[id^="seerpl1-${data.comstoriesid}"]').forEach(function (btn) {
                                btn.addEventListener('click', function () {
                                    const target = document.getElementById('seerpl2-${data.comstoriesid}');
                                    const target1 = document.getElementById('seerpl0-${data.comstoriesid}');
                                    const target0 = document.getElementById('seerpl1-${data.comstoriesid}');
                                    if (target) {
                                        target.classList.remove('hidden');
                                        target0.classList.add('hidden');
                                        target1.classList.remove('hidden');
                                    }
                                });
                            });
                            document.querySelectorAll('[id^="seerpl0-${data.comstoriesid}"]').forEach(function (btn) {
                                btn.addEventListener('click', function () {
                                    const target = document.getElementById('seerpl2-${data.comstoriesid}');
                                    const target1 = document.getElementById('seerpl0-${data.comstoriesid}');
                                    const target0 = document.getElementById('seerpl1-${data.comstoriesid}');
                                    if (target) {
                                        target.classList.add('hidden');
                                        target0.classList.remove('hidden');
                                        target1.classList.add('hidden');
                                    }
                                });
                            });
                        `;
                        const seerpl0 = document.getElementById(`seerpl0-${data.comstoriesid}`);
                        const seerpl1 = document.getElementById(`seerpl1-${data.comstoriesid}`);

                        if (seerpl0 && seerpl1) {
                            if (seerpl0.classList.contains('hidden')) {
                                seerpl1.innerHTML = `Lihat(${data.jumlah})`;
                            }
                            if (seerpl1.classList.contains('hidden')) {
                                seerpl0.innerHTML = `Tutup(${data.jumlah})`;
                            }
                        } else {
                            commentwrapcom.append(view);
                            commentwrapcom.append(view1);
                        }

                        if (!document.getElementById(`seerpl2-${data.comstoriesid}`)) {
                            commentwrapcom.appendChild(replies);
                            replies.append(reply, wrappercom3, bukatutup, dibalesin009);
                            reply.append(imgbalcom, dispcard2);
                            dispcard2.append(usernamebalcom, balcomment);
                            wrappercom3.append(reacted4, reactbalcom, scriptReacted1, createdat)
                            reacted4.append(reacted41, reacted42, reacted43, reacted44, reacted45);
                            reacted41.appendChild(img41);
                            reacted42.appendChild(img42);
                            reacted43.appendChild(img43);
                            reacted44.appendChild(img44);
                            reacted45.appendChild(img45);
                        }
                        else {
                            const gethead = document.getElementById(`seerpl2-${data.comstoriesid}`)
                            gethead.append(reply, wrappercom3, bukatutup, dibalesin009);
                            reply.append(imgbalcom, dispcard2);
                            dispcard2.append(usernamebalcom, balcomment);
                            wrappercom3.append(reacted4, reactbalcom, scriptReacted1, createdat)
                            reacted4.append(reacted41, reacted42, reacted43, reacted44, reacted45);
                            reacted41.appendChild(img41);
                            reacted42.appendChild(img42);
                            reacted43.appendChild(img43);
                            reacted44.appendChild(img44);
                            reacted45.appendChild(img45);
                        }
                    }
                });
                    window.channelBound = true;
                };
        </script>
        <script>
            document.addEventListener('input', function (e) {
                const target = e.target;

                if (target && target.matches('[class^="inpbalassaja-"]')) {
                    const inputClass = [...target.classList].find(cls => cls.startsWith('inpbalassaja-'));
                    const idSuffix = inputClass.substring('inpbalassaja-'.length);
                    const commentses = document.getElementById('inpbalassajahidden-' + idSuffix);
                    if (!commentses) return;

                    const comentses = target.value.trim();
                    const message = commentses.value.trim();

                    fetch('/broadcast-typing1', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ comentses, message })
                    })
                    .then(res => res.json())
                    .then(data => {
                    });
                }
            });


            if (typeof window.pusher1 === 'undefined') {
                window.pusher1 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                    cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                    forceTLS: true
                });
            }
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
                    }, 2000);
                }
            });
        </script>
        @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>