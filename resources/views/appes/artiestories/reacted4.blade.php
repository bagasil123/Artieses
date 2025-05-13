
@php $rcmId = $comment->commentartiestoriesid; @endphp
<div class="srcard3 srcard4-{{ $rcmId }} hidden" id="srcard4-{{ $rcmId }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="suka" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="senang" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="ketawa" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="sedih" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="marah" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons3 = document.querySelectorAll('.reaksi-btn3-{{ $rcmId }}');
                buttons3.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi3 = this.getAttribute('data-reaksi3');
                        const storyId3 = this.getAttribute('data-artiestoriesid3');
                        console.log('Reaksi:', reaksi3);
                        console.log('Story ID:', storyId3);

                        if (reaksi3 && storyId3) {
                            fetch("{{ route('uprcm1') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    reaksi: reaksi3,
                                    commentartiestoriesid: storyId3
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