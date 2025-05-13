@php
    $firstReply = $comment->replies->first();
    $idbalcom = $firstReply->balcomstoriesid ?? null;
    $commentlagi = $comment->commentartiestoriesid;

    $check = $comment->rcm1->pluck('reaksi')->unique();
            
    $getreactsuka = $check->where('reaksi', 'suka')->first();
    $getreactsenang = $check->where('reaksi', 'senang')->first();
    $getreactsedih = $check->where('reaksi', 'sedih')->first();
    $getreactmarah = $check->where('reaksi', 'marah')->first();
    $getreactketawa = $check->where('reaksi', 'ketawa')->first();
            
    $reactions = [
        'suka' => $getreactsuka,
        'marah' => $getreactmarah,
        'sedih' => $getreactsedih,
        'ketawa' => $getreactketawa,
        'senang' => $getreactsenang,
    ];
    $rcmId = $comment->commentartiestoriesid;
@endphp

 @php
            $username = $comment->userComments->username ?? 'defaultuser';
            $improfil = $comment->userComments->improfil ?? 'default.png';
            $path = $username . '/profil/' . $improfil;
            $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
        <div id="commentwrapcom-{{ $comment->commentartiestoriesid }}">
        <div class="cardcom001 cardcom001-{{ $comment->coderies }}">
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
        <div class="wrappercom2 wrappercom2-{{ $comment->coderies }}">
        @include('appes.artiestories.rcm')
        @include('appes.artiestories.cek1')
        </div>
        @if ($comment->replies->isEmpty())
        <div class="balaskan001" id="balaskan001-{{ $commentlagi }}">
            <p class="balaskan002 balaskansaja-{{ $commentlagi }} " id="balaskansaja-{{ $commentlagi }}">Balas</p>
            <p class="urungkan001 urungkansaja-{{ $commentlagi }} hidden" >Urungkan</p>
        </div>
        <div class="dibales lagi-{{ $commentlagi }} hidden" id="lagi-{{ $commentlagi }}">
            <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                <p id="brcmt2-{{ $commentlagi }}"></p>
            </div>
            <input type="text" class="inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
            <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}">&times;</button>
            <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}">
                <img class="iclikescmt" src="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>
        @include('appes.artiestories.js.balascommentarnya')
        @else 
            <p class="comment0010" id="seerpl1-{{ $commentlagi }}">Lihat({{ count($comment->replies) }})</p>
            <p class="comment00101 hidden" id="seerpl0-{{ $commentlagi }}">Tutup({{ count($comment->replies) }}) </p>
            <div class="replies replies-{{ $commentlagi }} hidden" id="seerpl2-{{ $commentlagi }}">
                @foreach ($comment->replies as $reply)
                    <div class="reply reply-{{ $commentlagi }}">
                        @php
                            $username = $reply->userBalcom->username ?? 'defaultuser';
                            $improfil = $reply->userBalcom->improfil ?? 'default.png';
                            $path = $username . '/profil/' . $improfil;
                            $ext = pathinfo($improfil, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
                            <img src="{{ asset($path) }}" class="creatorstories">
                        @endif
                        <div class="dispcard">
                            <p>{{ $reply->userBalcom->username }}</p>
                            <p>{{ $reply->comment }}</p>
                        </div>
                    </div>
                    <div class="wrappercom3 wrappercom3-{{ $commentlagi }}">
                    @include('appes.artiestories.rcm1')
                    @include('appes.artiestories.cek2')
                    </div>
                @endforeach
                @include('appes.artiestories.js.balcomjs')
                <div class="dibales1 lagi-{{ $commentlagi }}" id="lagi-{{ $commentlagi }}">
                    <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                        <p id="brcmt2-{{ $commentlagi }}"></p>
                    </div>
                    <input type="text" class="inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                    <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
                    <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}" id="close-dibales-{{ $commentlagi }}">&times;</button>
                    <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}" id="btnimg-sendcom-{{ $commentlagi }}">
                        <img class="iclikescmt" id="iclikescmtbalcom-{{ $commentlagi }}" src="{{ asset('partses/sendcomdm.png') }}">
                    </button>
                    <!-- <script>
                        if (typeof window.currentUserId2 === 'undefined') {
                            window.currentUserId2 = {{ session('userid') }};
                        }
                    </script>
                    <script>
                        document.querySelectorAll('.inpbalassaja-{{ $commentlagi }}').forEach(inputEl1 => {
                            const commentses = document.getElementById('inpbalassajahidden-{{ $commentlagi }}');
                            const clearBtn = document.getElementById('close-dibales-{{ $commentlagi }}');
                            let canSend = true;
                            let lastBroadcast = 0;
                            inputEl1.addEventListener('keydown', function (event) {
                                if (event.key === 'Enter' && canSend) {
                                    event.preventDefault();
                                    const message = inputEl1.value.trim();
                                    const comentses = commentses.value.trim();
                                    if (message.length > 0) {
                                        canSend = false;
                                        fetch('/enter-typing2', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({ message, comentses })
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            inputEl1.value = '';
                                            if (clearBtn) clearBtn.classList.add('hidden');
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
                        });
                        if (typeof window.pusher2 === 'undefined') {
                            window.pusher2 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                                forceTLS: true
                            });
                        }
                        if (typeof window.channel5 === 'undefined') {
                            window.channel5 = window.pusher2.subscribe('typing-channel2');
                        }
                        if (!window.channelBound2) {
                        window.channel5.bind('user.typing2', function (data) {
                            if (data.message && data.message !== "") {
                                console.log('ayotes');
                                const divhead = document.getElementById(`seerpl2-${data.comstoriesid}`);
                                const ambilmessage = document.getElementById(`lagi-${data.comstoriesid}`)
                                const ambilmessage1 = document.getElementById(`divbrcmt2-${data.comstoriesid}`);
                                const ambilmessage2 = document.getElementById(`brcmt2-${data.comstoriesid}`)
                                const ambilmessage3 = document.getElementById(`inpbalassaja-${data.comstoriesid}`)
                                const ambilmessage4 = document.getElementById(`inpbalassajahidden-${data.comstoriesid}`)
                                const ambilmessage5 = document.getElementById(`close-dibales-${data.comstoriesid}`)
                                const ambilmessage6 = document.getElementById(`btnimg-sendcom-${data.comstoriesid}`)
                                const ambilmessage7 = document.getElementById(`iclikescmtbalcom-${data.comstoriesid}`)
                                ambilmessage.remove();
                                ambilmessage1.remove();
                                ambilmessage2.remove();
                                ambilmessage3.remove();
                                ambilmessage4.remove();
                                ambilmessage5.remove();
                                ambilmessage6.remove();
                                ambilmessage7.remove();
                                const hasilrem = document.createElement('div');
                                hasilrem.className = `dibales1 lagi-${data.comstoriesid}`;
                                hasilrem.id = `lagi-${data.comstoriesid}`;
                                const hasilrem1 = document.createElement('div');
                                hasilrem1.className = `brcmt2 hidden`;
                                hasilrem1.id = `divbrcmt2-${data.comstoriesid}`;
                                const hasilrem2 = document.createElement('p');
                                hasilrem2.id = `brcmt2-${data.comstoriesid}`;
                                const hasilrem3 = document.createElement('input');
                                hasilrem3.type = `text`;
                                hasilrem3.className = `inpbalassaja-${data.comstoriesid}`;
                                hasilrem3.id = `inpbalassaja-${data.comstoriesid}`;
                                hasilrem3.placeholder = `Kirim komentar...`;
                                hasilrem3.required = true;
                                const hasilrem4 = document.createElement('input');
                                hasilrem4.type = `hidden`;
                                hasilrem4.value = `${data.comstoriesid}`;
                                hasilrem4.id = `inpbalassajahidden-${data.comstoriesid}`;
                                const hasilrem5 = document.createElement('button');
                                hasilrem5.type = 'button';
                                hasilrem5.className = `close-dibales close-dibales-${data.comstoriesid}`;
                                hasilrem5.id = `close-dibales-${data.comstoriesid}`;
                                hasilrem5.innerHTML = `&times;`;
                                const hasilrem6 = document.createElement('button');
                                hasilrem6.type = `submit`;
                                hasilrem6.className = `btnimg-sendcom btnimg-sendcom-${data.comstoriesid}`;
                                hasilrem6.id = `btnimg-sendcom-{{ $commentlagi }}`;
                                const hasilrem7 = document.createElement('img');
                                hasilrem7.className = `iclikescmt`;
                                hasilrem7.id = `iclikescmtbalcom-${data.comstoriesid}`;
                                hasilrem7.src = `{{ asset('partses/sendcomdm.png') }}`;
                                const divisi = document.createElement('div');
                                divisi.className = `reply reply-${data.comstoriesid}`;
                                const divimg = document.createElement('img');
                                divimg.src = `${data.username}/profil/${data.improfil}`;
                                divimg.className = `creatorstories`;
                                const divdispcard = document.createElement('div');
                                divdispcard.className = `dispcard`;
                                const mName = document.createElement('p');
                                mName.innerText = data.username;
                                const mMessage = document.createElement('p');
                                mMessage.innerText = data.message;
                                const wrappercomdiv3 = document.createElement('div');
                                wrappercomdiv3.className = `wrappercom3 wrappercom3-${data.comstoriesid}`;
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
                                divhead.append(divisi, wrappercomdiv3, hasilrem);
                                hasilrem.append(hasilrem1, hasilrem3, hasilrem4, hasilrem5, hasilrem6);
                                hasilrem1.appendChild(hasilrem2);
                                hasilrem6.appendChild(hasilrem7);
                                divisi.append(divimg, divdispcard);
                                divdispcard.append(mName, mMessage);
                                wrappercomdiv3.append(reacted4, reactbalcom, scriptReacted1, createdat);
                                reacted41.appendChild(img41);
                                reacted42.appendChild(img42);
                                reacted43.appendChild(img43);
                                reacted44.appendChild(img44);
                                reacted45.appendChild(img45);
                        }});            
                            window.channelBound2 = true;
                        };
                    </script> -->
                </div>
            </div>
    @endif
        </div>