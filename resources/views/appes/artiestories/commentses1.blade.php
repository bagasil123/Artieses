@php
    $firstReply = $comment->replies->first();
    $idbalcom = $firstReply->balcomstoriesid ?? null;
    $commentlagi = $comment->commentartiestoriesid;
    $storyCode = $story->coderies;

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
        @if ($comment->replies->isEmpty())
        <div class="balaskan001 ">
            <p class="balaskan002 balaskansaja-{{ $commentlagi }} " id="balaskansaja-{{ $commentlagi }}">Balas</p>
            <p class="urungkan001 urungkansaja-{{ $commentlagi }} hidden" >Urungkan</p>
        </div>
        <div class="dibales lagi-{{ $commentlagi }} hidden">
            <input type="text" class="inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $commentlagi }}">
            <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}">&times;</button>
            <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}">
                <img class="iclikescmt" src="{{ asset('partses/sendcomdm.png') }}">
            </button>
        </div>
        @include('appes.artiestories.js.balascommentarnya')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Pusher.logToConsole = true;
                const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                    cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                    forceTLS: true
                });
                
            });
        </script>
        @else 
            <p class="comment0010 {{ session('open_commentbalasan') == $commentlagi ? 'hidden' : 'block' }}" id="seerpl1-{{ $idbalcom }}">Lihat({{ count($comment->replies) }}) </p>
            <p class="comment00101 {{ session('open_commentbalasan') == $commentlagi ? 'block' : 'hidden' }}" id="seerpl0-{{ $idbalcom }}" style="margin-left: 141px;">Tutup({{ count($comment->replies) }}) </p>
            <div class="replies replies-{{ $commentlagi }} {{ session('open_commentbalasan') == $commentlagi ? 'block' : 'hidden' }}" id="seerpl2-{{ $idbalcom }}">
                @foreach ($comment->replies as $reply)
                    <div class="reply">
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
                    @include('appes.artiestories.rcm1')
                    @include('appes.artiestories.cek2')
                @endforeach
                @include('appes.artiestories.js.balcomjs')
                <div class="dibales1 lagi-{{ $commentlagi }}">
                    <input type="text" class="inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                    <input type="hidden" value="{{ $commentlagi }}">
                    <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}">&times;</button>
                    <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}">
                    <img class="iclikescmt" loading="lazy"
                        src="{{ asset('partses/sendcomdm.png') }}">
                    </button>
                </div>
            </div>
    @endif