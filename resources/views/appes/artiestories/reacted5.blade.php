
@php 
$rcm2 = $reply->balcomstoriesid; @endphp
<div class="srcard3 srcard5-{{ $rcm2 }} hidden"style="margin-top:-40px; margin-left:-15px; z-index:999;" id="srcard5-{{ $rcm2 }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="suka" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="senang" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="ketawa" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="sedih" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="marah" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons4 = document.querySelectorAll('.reaksi-btn4-{{ $rcm2 }}');
                buttons4.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi4 = this.getAttribute('data-reaksi4');
                        const storyId4 = this.getAttribute('data-artiestoriesid4');
                        console.log('Reaksi:', reaksi4);
                        console.log('Story ID:', storyId4);

                        if (reaksi4 && storyId4) {
                            fetch("{{ route('uprcm2') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    reaksi: reaksi4,
                                    balcomstoriesid: storyId4
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