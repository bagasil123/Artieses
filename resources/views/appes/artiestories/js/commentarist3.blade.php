@php
$rcm2 = $reply->balcomstoriesid;
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rbtnry5-{{ $rcm2 }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button5 = document.getElementById('rbtnry5-' + id);
                    const srcard5 = document.getElementById('srcard5-' + id);
                    srcard5.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button5 = document.getElementById('rbtnry5-' + id);
                    const srcard5 = document.getElementById('srcard5-' + id);
                    setTimeout(() => {
                        if (!srcard5.matches(':hover')) {
                            srcard5.classList.add('hidden');
                        }}, 0);
                });
            });
        });
</script>