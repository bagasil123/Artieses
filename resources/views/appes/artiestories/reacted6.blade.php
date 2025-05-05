
@php 
$rcm2 = $reply->balcomstoriesid; @endphp
<div class="srcard3 srcard6-{{ $rcm2 }} hidden"style="margin-top:-40px; margin-left:-15px; z-index:999;" id="srcard6-{{ $rcm2 }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="suka" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="senang" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="ketawa" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="sedih" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="marah" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons5 = document.querySelectorAll('.reaksi-btn5-{{ $rcm2 }}');
                buttons5.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi5 = this.getAttribute('data-reaksi5');
                        const storyId5 = this.getAttribute('data-artiestoriesid5');
                        console.log('Reaksi:', reaksi5);
                        console.log('Story ID:', storyId5);

                        if (reaksi5 && storyId5) {
                            fetch("{{ route('uprcm2') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    reaksi: reaksi5,
                                    balcomstoriesid: storyId5
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