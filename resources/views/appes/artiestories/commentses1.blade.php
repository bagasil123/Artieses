@php
    $firstReply = $comment->replies->first();
    $idbalcom = $firstReply->balcomstoriesid ?? null;
    $commentlagi = $comment->commentartiestoriesid;
    $storyCode = $story->coderies;
@endphp
        @if ($comment->replies->isEmpty())
        <div class="balaskan001 ">
            <p class="balaskan002 balaskansaja-{{ $commentlagi }} " id="balaskansaja-{{ $commentlagi }}">balas</p>
            <p class="urungkan001 urungkansaja-{{ $commentlagi }} hidden" >urungkan</p>
        </div>
        <div class="dibales lagi-{{ $commentlagi }} hidden">
            <form action="{{ route('ayokirim.komentar')}}" method="POST">
                @csrf
            <input type="text" class="inpbalassaja-{{ $commentlagi }}" name="inpbalassaja" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $commentlagi }}" name="inpbalassajahidden">
            <input type="hidden" value="{{ $storyCode }}" name="arahan">
            <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}">&times;</button>
            <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}">
            <img class="iclikestory" loading="lazy" width="10px"
                data-light="{{ asset('partses/sendcomlm.png') }}"
                data-dark="{{ asset('partses/sendcomdm.png') }}">
            </button>
            </form>
        </div>
        
        @include('appes.artiestories.js.balascommentarnya')
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
            <form action="{{ route('ayokirim.komentar')}}" method="POST">
                @csrf
            <input type="text" class="inpbalassaja-{{ $commentlagi }}" name="inpbalassaja" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
            <input type="hidden" value="{{ $commentlagi }}" name="inpbalassajahidden">
            <input type="hidden" value="{{ $storyCode }}" name="arahan">
            <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}">&times;</button>
            <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}">
            <img class="iclikestory" loading="lazy" width="10px"
                data-light="{{ asset('partses/sendcomlm.png') }}"
                data-dark="{{ asset('partses/sendcomdm.png') }}">
            </button>
            </form>
        </div>
            </div>
    @endif