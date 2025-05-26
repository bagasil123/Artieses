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
    $username = $comment->userComments->username ?? 'defaultuser';
    $improfil = $comment->userComments->improfil ?? 'default.png';
    $path = $username . '/profil/' . $improfil;
    $ext = pathinfo($improfil, PATHINFO_EXTENSION);
    $reactions = [
        'suka' => $getreactsuka,
        'marah' => $getreactmarah,
        'sedih' => $getreactsedih,
        'ketawa' => $getreactketawa,
        'senang' => $getreactsenang,
    ];
    use Illuminate\Support\Str;
    $prefix = '<img src="' . url('/Artiestoriescom/');
    
    $now = \Carbon\Carbon::now();
    $waktunya = $comment->created_at;
    $diffInMinutes001 = $waktunya->diffInMinutes($now);
    $diffInHours001 = $waktunya->diffInHours($now);
    $diffInDays001 = $waktunya->diffInDays($now);
    $diffInWeeks001 = $waktunya->diffInWeeks($now);
    $diffInMonths001 = $waktunya->diffInMonths($now);
    $diffInYears001 = $waktunya->diffInYears($now);
    $diffInMinutes = (int) $diffInMinutes001;
    $diffInHours = (int) $diffInHours001;
    $diffInDays = (int) $diffInDays001;
    $diffInWeeks = (int) $diffInWeeks001;
    $diffInMonths = (int) $diffInMonths001;
    $diffInYears = (int) $diffInYears001;
    if ($diffInMinutes < 60) {
        $timeAgo = $diffInMinutes . ' menit yang lalu';
    } elseif ($diffInHours < 24) {
        $timeAgo = $diffInHours . ' jam yang lalu';
    } elseif ($diffInDays < 7) {
        $timeAgo = $diffInDays . ' hari yang lalu';
    } elseif ($diffInWeeks < 4) {
        $timeAgo = $diffInWeeks . ' minggu yang lalu';
    } elseif ($diffInMonths < 12) {
        $timeAgo = $diffInMonths . ' bulan yang lalu';
    } else {
        $timeAgo = $diffInYears . ' tahun yang lalu';
    }
@endphp
<div id="commentwrapcom-{{ $comment->commentartiestoriesid }}">
    <div class="cardcom001 cardcom001-{{ $comment->coderies }}">
        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
            <a href="{{ route('profiles.show', ['username' => $comment->userComments->username]) }}">
                <img src="{{ asset($path) }}" class="creatorstories">
            </a>
        @endif
        <div class="dispcard">
            <div class="ddispcanam">
                <a href="{{ route('profiles.show', ['username' => $comment->userComments->username]) }}">
                    <p class="dispname">{{ $comment->userComments->username }}</p> 
                </a>
            </div>
            @if(Str::startsWith($comment->commentses, $prefix))
                <p class="comment001"> {!! $comment->commentses !!}</p>
            @else
                <p class="comment001">{{ $comment->commentses }}</p>
            @endif
        </div>
    </div>
    <div class="wrappercom2 wrappercom2-{{ $comment->coderies }}">
        @if ($comment->replies->isEmpty())
            <div class="balaskan001" id="balaskan001-{{ $commentlagi }}">
                @include('appes.artiestories.rcm')
                <p class="balaskan002 balaskansaja-{{ $commentlagi }} " id="balaskansaja-{{ $commentlagi }}">Balas</p>
                <p class="urungkan001 urungkansaja-{{ $commentlagi }} hidden" >Urungkan</p>
                <p class="captionStoriess gg12">{{ $timeAgo }}</p>
            </div>
            <div class="dibales lagi-{{ $commentlagi }} hidden" id="lagi-{{ $commentlagi }}">
                <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                    <p id="brcmt2-{{ $commentlagi }}"></p>
                </div>
                <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp1" id="importbtn1-{{ $commentlagi }}">
                <input type="file" accept="image/*" id="filepicker1-{{ $commentlagi }}" class="hidden" />
                <input type="text" class="inpbalassaja inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
                <button type="button" class="close-dibales close-dibales-{{ $commentlagi }} hidden" id="close-dibales-{{ $commentlagi }}"x>&times;</button>
                <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}" id="btnimg-sendcom-{{ $commentlagi }}">
                    <img class="iclikescmt1" src="{{ asset('partses/sendcomdm.png') }}">
                </button>
            </div>
        @else 
            <div class="balaskan001" id="balaskan001-{{ $commentlagi }}">
                @include('appes.artiestories.rcm')
                <p class="comment0010" id="seerpl1-{{ $commentlagi }}">Lihat({{ count($comment->replies) }})</p>
                <p class="comment00101 hidden" id="seerpl0-{{ $commentlagi }}">Tutup({{ count($comment->replies) }}) </p>
                <p class="captionStoriess gg12">{{ $timeAgo }}</p>
            </div>
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
                        <a href="{{ route('profiles.show', ['username' => $reply->userBalcom->username]) }}">
                            <img src="{{ asset($path) }}" class="creatorstories">
                        </a>
                        @endif
                        <div class="dispcard">
                            <a href="{{ route('profiles.show', ['username' => $reply->userBalcom->username]) }}">
                                <p>{{ $reply->userBalcom->username }}</p>
                            </a>
                            @if(Str::startsWith($reply->comment, $prefix))
                                <p>{!! $reply->comment !!}</p>
                            @else
                                <p>{{ $reply->comment }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="wrappercom3 wrappercom3-{{ $commentlagi }}">
                        @include('appes.artiestories.rcm1')
                        @include('appes.artiestories.cek2')
                    </div>
                @endforeach
                <div class="dibales1 lagi-{{ $commentlagi }}" id="lagi-{{ $commentlagi }}">
                    <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                        <p id="brcmt2-{{ $commentlagi }}"></p>
                    </div>
                    <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp1" id="importbtn1-{{ $commentlagi }}">
                    <input type="file" accept="image/*" id="filepicker1-{{ $commentlagi }}" class="hidden" />
                    <input type="text" class="inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                    <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
                    <button type="button" class="close-dibales close-dibales-{{ $commentlagi }}" id="close-dibales-{{ $commentlagi }}">&times;</button>
                    <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}" id="btnimg-sendcom-{{ $commentlagi }}">
                        <img class="iclikescmt1" id="iclikescmtbalcom-{{ $commentlagi }}" src="{{ asset('partses/sendcomdm.png') }}">
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const storyCode1 = '{{ $commentlagi }}';
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
        const importBtn1 = document.getElementById('importbtn1-' + storyCode1);
        importBtn1.addEventListener('click', () => {
            fileInput1.click();
        });
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
        input1.addEventListener('paste', function (e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    const file = items[i].getAsFile();
                    const reader1 = new FileReader();
                    reader1.onload = function (event) {
                        showImagePreview1(event.target.result, storyCode1);
                    };
                    reader1.readAsDataURL(file1);
                }
            }
        });
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
        delimg.innerHTML = `&times;`;
        delimg.style.cursor = 'pointer';
        delimg.addEventListener('click', () => preview.remove());
        preview.appendChild(img);
        preview.appendChild(delimg);
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        input1.value = "";
        const clearBtn1 = document.getElementById(`close-dibales-${storyCode1}`);
        clearBtn1.classList.add('hidden');
        const sendBtn = document.getElementById('lagi-' + storyCode1);
        sendBtn.parentNode.insertBefore(preview, sendBtn);
    }
</script>