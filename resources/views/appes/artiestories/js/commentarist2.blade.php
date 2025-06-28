<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="rbtnry4-"]').forEach(rbtnry4 => {
            const id = rbtnry4.id.replace('rbtnry4-', '');
            const button = document.getElementById('rbtnry4-' + id);
                button.addEventListener('mouseenter', function () {
                    const srcard4 = document.getElementById('srcard4-' + id);
                    srcard4.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const srcard4 = document.getElementById('srcard4-' + id);
                    setTimeout(() => {
                        if (!srcard4.matches(':hover')) {
                            srcard4.classList.add('hidden');
                        }
                    }, 300);
                });
        });
    });
</script>