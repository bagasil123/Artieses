@php 
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
    <div class="brcmt hidden" id="divbrcmt-{{ $storyCode }}">
        <p id="brcmt-{{ $storyCode }}">test</p>
    </div>
        <div class="chat chat-{{ $storyCode }}">
            <input type="text" class="inpcom inpcom-{{ $storyCode }}" id="inpcom-{{ $storyCode }}" placeholder="Kirim komentar..." required/>
            <input type="hidden" value="{{ $storyCode }}" id="commentses-{{ $storyCode }}">
            <button type="button" class="balinpcom balinpcom-{{ $storyCode }} hidden" id="balinpcom-{{ $storyCode }}">&times;</button>
            <button type="submit" class="sendcom sendcom-{{ $storyCode }}" id="sendcom-{{ $storyCode }}">
                <img class="iclikestory" loading="lazy" src="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>      
        <script>
            document.querySelectorAll('.inpcom-{{ $storyCode }}').forEach(inputEl => {
                const storyCode = inputEl.id.replace('inpcom-', '');
                const clearBtn = document.getElementById(`balinpcom-${storyCode}`);

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
                            const comentses = commentses.value.trim();

                            if (message.length > 0) {
                                canSend = false; // ⛔ Lock agar tidak bisa kirim lagi selama cooldown
                                fetch('/enter-typing', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({ message, comentses })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    inputEl.value = '';
                                    clearBtn.classList.add('hidden');
                                    console.log('Sent:', data);
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
                        if (now - lastBroadcast < 1000) return; // ⛔ Skip jika kurang dari 1 detik

                        lastBroadcast = now;
                        const comentses = document.getElementById('inpcom-{{ $storyCode }}').value.trim();
                        fetch('/broadcast-typing', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ comentses })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log('Broadcast Sent:', data);
                        });
                    });


                }
            });
            document.addEventListener('DOMContentLoaded', function () {
                Pusher.logToConsole = true;
                const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                    cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                    forceTLS: true
                });
                const channel = pusher.subscribe('typing-channel');
                channel.bind('user.typing', function (data) {
                    if (data.message && data.message !== "") {
                        const container = document.getElementById('wrappercom1');
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
                        const inpbalassaja = document.createElement('input');
                        inpbalassaja.className = `inpbalassaja-${data.comstoriesid}`;
                        inpbalassaja.setAttribute('name', 'inpbalassaja');
                        inpbalassaja.id = `inpbalassaja-${data.comstoriesid}`;
                        inpbalassaja.setAttribute('placeholder', 'Kirim komentar...');
                        inpbalassaja.required;
                        const inpbalassajahidden = document.createElement('input');
                        inpbalassajahidden.className = `hidden`;
                        inpbalassajahidden.setAttribute(`value` , `${data.comstoriesid}`);
                        inpbalassajahidden.setAttribute(`name` , `inpbalassajahidden`);
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
                        script.innerContent = `
                            document.querySelectorAll('.rbtnry3-${data.comstoriesid}').forEach(function (button) {
                                button.addEventListener('mouseenter', function () {
                                    const id = this.id.split('-')[1];
                                    const button3 = document.getElementById('rbtnry3-' + id);
                                    const srcard3 = document.getElementById('srcard3-' + id);
                                    srcard3.classList.remove('hidden');
                                });
                                button.addEventListener('mouseleave', function () {
                                    const id = this.id.split('-')[1];
                                    const button3 = document.getElementById('rbtnry3-' + id);
                                    const srcard3 = document.getElementById('srcard3-' + id);
                                    setTimeout(() => {
                                        if (!srcard3.matches(':hover')) {
                                            srcard3.classList.add('hidden');
                                        }}, 0);
                                });
                            });
                        `;
                        const script = document.createElement('script');
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
                        container.append(card, wrappercom2, balaskan001, dibaleslagi);
                        card.append(img, dispcard);
                        dispcard.append(ddispcanam, pComment);
                        wrappercom2.append(reacted3, suka, created);
                        reacted3.append(reacted31, reacted32, reacted33, reacted34, reacted35);
                        reacted31.appendChild(img31);
                        reacted32.appendChild(img32);
                        reacted33.appendChild(img33);
                        reacted34.appendChild(img34);
                        reacted35.appendChild(img35);
                        balaskan001.append(balaskan, urungkansaja);
                        dibaleslagi.append(inpbalassaja, closeDibales, inpbalassajahidden, submitDibales, script);
                        submitDibales.appendChild(dibalesIMG);
                    }
                }); 
                const channel1 = pusher.subscribe('broadcast-channel');
                channel1.bind('broadcast.typing', function (data) {
                    if (data.reqplat && data.reqplat.length > 0) {
                        console.log(`Broadcast sedang  mengetik:${data.reqplat}`);
                        const cardmengetik = document.getElementById('divbrcmt-{{ $storyCode }}');
                        const teksmengetik = document.getElementById('brcmt-{{ $storyCode }}');
                        cardmengetik.classList.remove('hidden');
                        teksmengetik.innerText = `${data.username} sedang mengetik...`;
                        clearTimeout(window.typingTimeout);
                        window.typingTimeout = setTimeout(() => {
                            teksmengetik.innerText = '';
                            cardmengetik.classList.add('hidden');
                        }, 2000);
                    }
                });
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
                            console.log(data);
                            if (!data.logged_in) {
                                sessionStorage.setItem('alert', data.alert);
                                sessionStorage.setItem('form', data.form);
                                window.location.href = data.redirect;
                                return;
                            }
                            console.log(data.message);
                            if (data.csrf) {
                                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                            }
                        })
                        .catch(err => {
                            console.error('Fetch error:', err);
                        });
                    } else {
                        console.error('Reaksi atau Story ID tidak valid!');
                    }
                }
            });
        </script>
        <script>

        </script>
        @include('appes.artiestories.js.commentjs')
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
    @include('appes.artiestories.js.commentarist001')
</div>