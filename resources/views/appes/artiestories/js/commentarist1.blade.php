@php
$rcmId = $comment->commentartiestoriesid; 
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rbtnry3-{{ $rcmId }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button3 = document.getElementById('rbtnry3-' + id);
                    const srcard3 = document.getElementById('srcard3-' + id);
                    srcard3.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button3 = document.getElementById('rbtnry3-' + id);
                    const srcard3 = document.getElementById('srcard3-' + id);
                    setTimeout(() => {
                        if (!srcard3.matches(':hover')) {
                            srcard3.classList.add('hidden');
                        }}, 0);
                });
            });
        });
</script>