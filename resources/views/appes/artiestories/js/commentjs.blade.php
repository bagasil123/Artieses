@php $storyCode = $story->coderies; @endphp
<script>
document.addEventListener('DOMContentLoaded', function () {
    const storyCode = '{{ $storyCode }}';
    const input = document.getElementById("inpcom-" + storyCode);
    const clearBtn = document.getElementById("balinpcom-" + storyCode);

    if (input && clearBtn) {
        input.addEventListener('input', function () {
            if (input.value.length > 0) {
                clearBtn.classList.add('block')
                clearBtn.classList.remove('hidden')
            }
            if (input.value.length < 0) {
                clearBtn.classList.add('hidden')
                clearBtn.classList.remove('block')
            }
        });

        clearBtn.addEventListener('click', function () {
            input.value = "";
            clearBtn.classList.add('hidden')
        });
    }
});
</script>
