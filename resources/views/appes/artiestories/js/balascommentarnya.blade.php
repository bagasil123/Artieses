@php
$rcmId = $comment->commentartiestoriesid; 
@endphp
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.balaskansaja-{{ $rcmId }}').forEach(function (button) {
        button.addEventListener('click', function () {
            const balaskanlagi = document.querySelector('.lagi-{{ $rcmId }}');
            const balaskansaja = document.querySelector('.balaskansaja-{{ $rcmId }}');
            const urungkansaja = document.querySelector('.urungkansaja-{{ $rcmId }}');
            balaskanlagi.classList.remove('hidden');
            balaskansaja.classList.add('hidden');
            urungkansaja.classList.remove('hidden');
        });
    });
    document.querySelectorAll('.close-dibales-{{ $rcmId }}').forEach(function (button) {
        button.addEventListener('click', function () {
            const inpbalassaja = document.querySelector('.inpbalassaja-{{ $rcmId }}');
            inpbalassaja.value = "";
        });
    });
    document.querySelectorAll('.urungkansaja-{{ $rcmId }}').forEach(function (button) {
        button.addEventListener('click', function () {
            const balaskanlagi = document.querySelector('.lagi-{{ $rcmId }}');
            const balaskansaja = document.querySelector('.balaskansaja-{{ $rcmId }}');
            const urungkansaja = document.querySelector('.urungkansaja-{{ $rcmId }}');
            const inpbalassaja = document.querySelector('.inpbalassaja-{{ $rcmId }}');
            inpbalassaja.value = "";
            balaskanlagi.classList.add('hidden');
            balaskansaja.classList.remove('hidden');
            urungkansaja.classList.add('hidden');
        });
    });
});
</script>
