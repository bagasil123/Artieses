@php
$rcm2 = $reply->balcomstoriesid;
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rbtnry6-{{ $rcm2 }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button6 = document.getElementById('rbtnry6-' + id);
                    const srcard6 = document.getElementById('srcard6-' + id);
                    srcard6.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button6 = document.getElementById('rbtnry6-' + id);
                    const srcard6 = document.getElementById('srcard6-' + id);
                    setTimeout(() => {
                        if (!srcard6.matches(':hover')) {
                            srcard6.classList.add('hidden');
                        }}, 0);
                });
            });
        });
</script>