
@php $storyId = $story->artiestoriesid; @endphp
<div class="srcard2 srcard2-{{ $storyId }} hidden"style="margin-top:-15px; z-index:999;" id="srcard2-{{ $storyId }}">
        <a href="javascript:void(0)" >
            <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn1-{{ $storyId }}" data-reaksi1="suka" data-artiestoriesid1="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyId }}" data-reaksi1="senang" data-artiestoriesid1="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyId }}" data-reaksi1="ketawa" data-artiestoriesid1="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyId }}" data-reaksi1="sedih" data-artiestoriesid1="{{ $story->artiestoriesid }}">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyId }}" data-reaksi1="marah" data-artiestoriesid1="{{ $story->artiestoriesid }}">
        </a>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons1 = document.querySelectorAll('.reaksi-btn1-{{ $storyId }}');
                buttons1.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const reaksi1 = this.getAttribute('data-reaksi1');
                        const storyId1 = this.getAttribute('data-artiestoriesid1');
                        console.log('Reaksi:', reaksi1);
                        console.log('Story ID:', storyId1);

                        if (reaksi1 && storyId1) {
                            fetch("{{ route('uprcm0') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    reaksi: reaksi1,
                                    artiestoriesid: storyId1
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