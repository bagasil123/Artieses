
@php 
$storyCode = $story->coderies; @endphp
<script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rbtnry-{{ $storyCode }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button1 = document.getElementById('rbtnry1-' + id);
                    const srcard1 = document.getElementById('srcard1-' + id);
                    srcard1.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button1 = document.getElementById('rbtnry1-' + id);
                    const srcard1 = document.getElementById('srcard1-' + id);
                    setTimeout(() => {
                        if (!srcard1.matches(':hover')) {
                            srcard1.classList.add('hidden');
                        }}, 0);
                });
            });
            document.querySelectorAll('.rbtnry2-{{ $storyCode }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button2 = document.getElementById('rbtnry2-' + id);
                    const srcard2 = document.getElementById('srcard2-' + id);
                    srcard2.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button2 = document.getElementById('rbtnry2-' + id);
                    const srcard2 = document.getElementById('srcard2-' + id);
                    setTimeout(() => {
                        if (!srcard2.matches(':hover')) {
                            srcard2.classList.add('hidden');
                        }}, 0);
                });
            });
            document.querySelectorAll('.cardstories-{{ $storyCode }}, .cbtnry1-{{ $storyCode }}').forEach(function (button) {
            if (button.tagName.toLowerCase() === 'video') return;
                button.addEventListener('click', function () {
                    const id = this.id.split('-')[1];
                    const input = document.getElementById("inpcom-" + id);
                    const modal = document.getElementById("commentarist-" + id);
                    history.pushState({}, '', 'Artiestories?GetContent=' + id);
                    document.querySelectorAll('video').forEach(function(video) {
                        video.pause();
                    });
                    if (modal) {
                        modal.classList.remove("hidden");
                        const closeBtn = document.getElementById("closeCommentarist-" + id);
                        document.body.classList.add('noscroll');
                        if (closeBtn) {
                            closeBtn.addEventListener("click", function () {
                                input.value = "";
                                modal.classList.add("hidden");
                                history.pushState({}, '','Artieses');
                                document.body.classList.remove('noscroll');
                            });
                        }
                    }
                });
            });
            document.querySelectorAll('.closecmtrst').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = this.id.split('-')[1];
                    const input = document.getElementById("inpcom-" + id);
                    const modal = document.getElementById("commentarist-" + id);
                    document.body.classList.remove('noscroll');
                    modal.classList.add("hidden");
                    modal.classList.remove("block");
                    history.pushState({}, '','Artieses');
                });
            });
            window.addEventListener('popstate', function () {
                const params = new URLSearchParams(window.location.search);
                const id = params.get('GetContent');

                if (id) {
                    const modal = document.getElementById("commentarist-" + id);
                    const input = document.getElementById("inpcom-" + id);
                    if (modal) {
                        modal.classList.remove("hidden");
                        document.body.classList.add('noscroll');

                        const closeBtn = document.getElementById("closeCommentarist-" + id);
                        if (closeBtn) {
                            closeBtn.addEventListener("click", function () {
                                input.value = "";
                                modal.classList.add("hidden");
                                history.pushState({}, '', 'Artieses');
                                document.body.classList.remove('noscroll');
                            });
                        }
                    }
                } else {
                    document.querySelectorAll('.commentarist').forEach(modal => {
                        modal.classList.add("hidden");
                    });
                    document.body.classList.remove('noscroll');
                }
            });

        });
        </script>
