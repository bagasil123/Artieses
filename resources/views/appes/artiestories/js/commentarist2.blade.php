@php
$rcmId = $comment->commentartiestoriesid; 
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rbtnry4-{{ $rcmId }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button4 = document.getElementById('rbtnry4-' + id);
                    const srcard4 = document.getElementById('srcard4-' + id);
                    srcard4.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button4 = document.getElementById('rbtnry4-' + id);
                    const srcard4 = document.getElementById('srcard4-' + id);
                    setTimeout(() => {
                        if (!srcard4.matches(':hover')) {
                            srcard4.classList.add('hidden');
                        }}, 0);
                });
            });
        });
</script>