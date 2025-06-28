<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="rbtnry3-"]').forEach(rbtnry3 => {
            const id = rbtnry3.id.replace('rbtnry3-', '');
            const button = document.getElementById('rbtnry3-' + id);
                button.addEventListener('mouseenter', function () {
                    const srcard3 = document.getElementById('srcard3-' + id);
                    srcard3.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const srcard3 = document.getElementById('srcard3-' + id);
                    setTimeout(() => {
                        if (!srcard3.matches(':hover')) {
                            srcard3.classList.add('hidden');
                        }
                    }, 300);
                });
        });
    });
</script>