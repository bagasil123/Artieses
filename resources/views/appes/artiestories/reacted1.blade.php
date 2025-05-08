
@php $storyCode = $story->coderies; @endphp
<div class="srcard1 srcard1-{{ $storyCode }} hidden"style="margin-top:-15px; z-index:999;" id="srcard1-{{ $storyCode }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="suka" data-artiestoriesid="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="senang" data-artiestoriesid="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="ketawa" data-artiestoriesid="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="sedih" data-artiestoriesid="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="marah" data-artiestoriesid="{{ $story->artiestoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.reaksi-btn-{{ $storyCode }}');
                buttons.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi = this.getAttribute('data-reaksi');
                        const storyId = this.getAttribute('data-artiestoriesid');
                        console.log('Reaksi:', reaksi);
                        console.log('Story ID:', storyId);

                        if (reaksi && storyId) {
                            fetch("{{ route('uprcm0') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    reaksi: reaksi,
                                    artiestoriesid: storyId
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