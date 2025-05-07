
@php $rcmId = $comment->commentartiestoriesid; @endphp
<div class="srcard3 srcard3-{{ $rcmId }} hidden"style="margin-top:-55px; z-index:999;" id="srcard3-{{ $rcmId }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:3px !important;" class="iclikestory reaksi-btn2-{{ $rcmId }}" data-reaksi2="suka" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn2-{{ $rcmId }}" data-reaksi2="senang" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn2-{{ $rcmId }}" data-reaksi2="ketawa" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn2-{{ $rcmId }}" data-reaksi2="sedih" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn2-{{ $rcmId }}" data-reaksi2="marah" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons2 = document.querySelectorAll('.reaksi-btn2-{{ $rcmId }}');
                buttons2.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi2 = this.getAttribute('data-reaksi2');
                        const storyId2 = this.getAttribute('data-artiestoriesid2');
                        console.log('Reaksi:', reaksi2);
                        console.log('Story ID:', storyId2);

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
                    });
                });
            });
        </script>
        </div>