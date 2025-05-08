@php $storyCode = $story->coderied; @endphp
<script>
document.addEventListener('DOMContentLoaded', function () {
    const storyId = '{{ $storyCode }}';
    const input = document.getElementById("inpcom-" + storyId);
    const clearBtn = document.getElementById("balinpcom-" + storyId);

    if (input && clearBtn) {
        input.addEventListener('input', function () {
            clearBtn.style.display = this.value.length > 0 ? "block" : "none";
        });

        clearBtn.addEventListener('click', function () {
            input.value = "";
            clearBtn.style.display = "none";
            input.focus();
        });
    }
});
</script>
