<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="rbtnry-"]').forEach(rbtnry => {
            const id = rbtnry.id.replace('rbtnry-', '');
            rbtnry.addEventListener('mouseenter', function () {
                const button1 = document.getElementById('rbtnry1-' + id);
                const srcard1 = document.getElementById('srcard1-' + id);
                srcard1.classList.remove('hidden');
            });
            rbtnry.addEventListener('mouseleave', function () {
                const button1 = document.getElementById('rbtnry1-' + id);
                const srcard1 = document.getElementById('srcard1-' + id);
                setTimeout(() => {
                    if (!srcard1.matches(':hover')) {
                        srcard1.classList.add('hidden');
                    }}, 0);
            });
        });
        document.querySelectorAll('[id^="rbtnry2-"]').forEach(rbtnry2 => {
            const id = rbtnry2.id.replace('rbtnry2-', '');
            rbtnry2.addEventListener('mouseenter', function () {
                const button2 = document.getElementById('rbtnry2-' + id);
                const srcard2 = document.getElementById('srcard2-' + id);
                srcard2.classList.remove('hidden');
            });
            rbtnry2.addEventListener('mouseleave', function () {
                const button2 = document.getElementById('rbtnry2-' + id);
                const srcard2 = document.getElementById('srcard2-' + id);
                setTimeout(() => {
                    if (!srcard2.matches(':hover')) {
                        srcard2.classList.add('hidden');
                    }}, 0);
            });
        });
        document.querySelectorAll('[id^="cardstories-"], [id^="cbtnry1-"]').forEach(cardstories => {
            let id = cardstories.id;
            const match = id.match(/(?:cardstories|cbtnry1)-([^-]+)(?:-\d+)?/);
            if (match) {
                id = match[1];
            }
            if (cardstories.tagName.toLowerCase() === 'video') return;
            cardstories.addEventListener('click', function () {
                const input = document.getElementById("inpcom-" + id);
                const modal = document.getElementById("commentarist-" + id);
                const currentPath = window.location.pathname;
                const isProfile = currentPath.startsWith('/profiles/');
                let newUrl = '';
                if (isProfile) {
                    const parts = currentPath.split('/');
                    const username = parts[2] ?? '';
                    newUrl = `/profiles/${username}/Artiestories?GetContent=${id}`;
                } else {
                    newUrl = `Artiestories?GetContent=${id}`;
                }
                history.pushState({}, '', newUrl);
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
                            document.body.classList.remove('noscroll');
                            let path = window.location.pathname;
                            let isProfile = path.startsWith('/profiles/');
                            if (isProfile) {
                                let backUrl = path.replace(/\/Artiestories(\?.*)?$/i, '');
                                history.pushState({}, '', backUrl);
                            } else {
                                history.pushState({}, '', 'Artieses');
                            }
                        });
                    }
                }
            });
        });
        
        function getBackUrl() {
            const path = window.location.pathname + window.location.search;
            const isProfile = path.startsWith('/profiles/') && path.includes('/Artiestories');
            if (isProfile) {
                return path.replace(/\/Artiestories(\?.*)?$/i, '');
            }
            return 'Artieses';
        }
        document.querySelectorAll('[id^="closeCommentarist-"]').forEach(closeBtn => {
            const id = closeBtn.id.replace('closeCommentarist-', '');
            closeBtn.addEventListener('click', function () {
                const input = document.getElementById("inpcom-" + id);
                const modal = document.getElementById("commentarist-" + id);
                document.body.classList.remove('noscroll');
                if (modal) {
                    modal.classList.add("hidden");
                    modal.classList.remove("block");
                }
                history.pushState({}, '', getBackUrl());
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
                            document.body.classList.remove('noscroll');
                            history.pushState({}, '', getBackUrl());
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