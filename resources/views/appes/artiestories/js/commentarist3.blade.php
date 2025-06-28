<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="rbtnry5-"]').forEach(rbtnry5 => {
            const id = rbtnry5.id.replace('rbtnry5-', '');
            const button = document.getElementById('rbtnry5-' + id);
                button.addEventListener('mouseenter', function () {
                    const srcard5 = document.getElementById('srcard5-' + id);
                    srcard5.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const srcard5 = document.getElementById('srcard5-' + id);
                    setTimeout(() => {
                        if (!srcard5.matches(':hover')) {
                            srcard5.classList.add('hidden');
                        }
                    }, 300);
                });
        });
    });
</script>