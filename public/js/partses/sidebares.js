document.addEventListener("DOMContentLoaded", function () {
    const buates = document.getElementById("buates"); // Gunakan ID yang sesuai
    const cardBu = document.getElementById("cardbu");
    const alertBox = document.getElementById('carlert');
        if (alertBox && alertBox.style.display !== 'none') {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => {
                    alertBox.style.display = 'none';
                }, 500); // waktu tunggu untuk transisi hilang
            }, 5000); // hilang setelah 5 detik
        }

    if (buates && cardBu) {
        buates.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            cardBu.classList.toggle("show");
        });

        document.addEventListener("click", function(event) {
            if (!cardBu.contains(event.target) && !buates.contains(event.target)) {
                cardBu.classList.remove("show");
            }
        });   
    }
});
