@php
    $firstReply = $comment->replies->first();
    $idbalcom = $firstReply->balcomstoriesid ?? null;
@endphp
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="seerpl1-{{ $idbalcom }}"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.id.split('-')[1];
            const target = document.getElementById('seerpl2-' + id);
            const target1 = document.getElementById('seerpl0-' + id);
            const target0 = document.getElementById('seerpl1-' + id);
            if (target) {
                target.classList.remove('hidden');
                target0.classList.add('hidden');
                target1.classList.remove('hidden');
            }
        });
    });
    document.querySelectorAll('[id^="seerpl0-{{ $idbalcom }}"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.id.split('-')[1];
            const target = document.getElementById('seerpl2-' + id);
            const target1 = document.getElementById('seerpl0-' + id);
            const target0 = document.getElementById('seerpl1-' + id);
            if (target) {
                target.classList.add('hidden');
                target0.classList.remove('hidden');
                target1.classList.add('hidden');
            }
        });
    });
});
</script>

