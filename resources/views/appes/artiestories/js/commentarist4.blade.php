<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="rbtnry6-"]').forEach(rbtnry6 => {
            const id = rbtnry6.id.replace('rbtnry6-', '');
            const button = document.getElementById('rbtnry6-' + id);
                button.addEventListener('mouseenter', function () {
                    const srcard6 = document.getElementById('srcard6-' + id);
                    srcard6.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const srcard6 = document.getElementById('srcard6-' + id);
                    setTimeout(() => {
                        if (!srcard6.matches(':hover')) {
                            srcard6.classList.add('hidden');
                        }
                    }, 300);
                });
        });
    });
</script>