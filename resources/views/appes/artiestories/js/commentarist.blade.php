
@php 
$storyId = $story->artiestoriesid; @endphp
<script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rbtnry-{{ $storyId }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button1 = document.getElementById('rbtnry1-' + id);
                    const srcard1 = document.getElementById('srcard1-' + id);
                    srcard1.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button1 = document.getElementById('rbtnry1-' + id);
                    const srcard1 = document.getElementById('srcard1-' + id);
                    setTimeout(() => {
                        if (!srcard1.matches(':hover')) {
                            srcard1.classList.add('hidden');
                        }}, 0);
                });
            });
            document.querySelectorAll('.rbtnry2-{{ $storyId }}').forEach(function (button) {
                button.addEventListener('mouseenter', function () {
                    const id = this.id.split('-')[1];
                    const button2 = document.getElementById('rbtnry2-' + id);
                    const srcard2 = document.getElementById('srcard2-' + id);
                    srcard2.classList.remove('hidden');
                });
                button.addEventListener('mouseleave', function () {
                    const id = this.id.split('-')[1];
                    const button2 = document.getElementById('rbtnry2-' + id);
                    const srcard2 = document.getElementById('srcard2-' + id);
                    setTimeout(() => {
                        if (!srcard2.matches(':hover')) {
                            srcard2.classList.add('hidden');
                        }}, 0);
                });
            });
            document.querySelectorAll('.cardstories-{{ $storyId }}, .cbtnry1-{{ $storyId }}').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = this.id.split('-')[1];
                    const input = document.getElementById("inpcom-" + id);
                    const modal = document.getElementById("commentarist-" + id);
                    console.log("Klik komentar story ID:", id);
                    if (modal) {
                        modal.classList.remove("hidden");

                        const closeBtn = document.getElementById("closeCommentarist-" + id);
                        if (closeBtn) {
                            closeBtn.addEventListener("click", function () {
                                input.value = "";
                                console.log("Klik komentar story ID:", id);
                                modal.classList.add("hidden");
                            });
                        }

                        // Klik luar modal
                        modal.addEventListener("click", function (e) {
                            if (e.target === modal) {
                                modal.classList.add("hidden");
                            }
                        });
                    }
                });
            });
        });
        </script>
