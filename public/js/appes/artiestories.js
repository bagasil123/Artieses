const dropAreaartiestories = document.getElementById('drop-area-artiestories');
const fileInputartiestories = document.getElementById('fileElem-artiestories');

dropAreaartiestories.addEventListener('click', () => fileInputartiestories.click());

dropAreaartiestories.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropAreaartiestories.classList.add('dragover');
});

dropAreaartiestories.addEventListener('dragleave', () => {
  dropAreaartiestories.classList.remove('dragover');
});

dropAreaartiestories.addEventListener('drop', (e) => {
  e.preventDefault();
  dropAreaartiestories.classList.remove('dragover');

  if (e.dataTransfer.files.length) {
    fileInputartiestories.files = e.dataTransfer.files;

    dropAreaartiestories.querySelector('p').textContent = `File terkirim`;
  }
});

document.addEventListener("DOMContentLoaded", function () {
    const cardUpload = document.getElementById("cardupload-artiestories");
    const uploadFile = document.getElementById("uploadfile-artiestories");
    const toggleBtn = document.getElementById("pilihkategorian-artiestories");
    const kategoriBox = document.getElementById("pilihkategori-artiestories");
    const kategoriBtns = document.querySelectorAll(".kategori-btn-artiestories");
    const kseoInput = document.getElementById("kseo-artiestories");

    const closeKategoriBtn = document.getElementById("close-kategori-artiestories");
  
    if (cardUpload && uploadFile) {
        cardUpload.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            uploadFile.classList.toggle("show");
        });
        document.addEventListener("click", function(event) {
            if (!cardUpload.contains(event.target) && !uploadFile.contains(event.target)) {
                uploadFile.classList.remove("show");
            }
        });
    }
    kategoriBox.classList.add("hidden");

    toggleBtn.addEventListener("click", function () {
        kategoriBox.classList.toggle("hidden");
    });

    kategoriBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            kategoriBtns.forEach(b => b.classList.remove("selected"));
            btn.classList.add("selected");
            kseoInput.value = btn.getAttribute("data-kategori-artiestories");
            kategoriBox.classList.add("hidden");
            toggleBtn.textContent = `Kategori: ${btn.getAttribute("data-kategori-artiestories")}`;
        });
    });
    
    if (closeKategoriBtn && kategoriBox) {
      closeKategoriBtn.addEventListener("click", function () {
          kategoriBox.classList.add("hidden");
      });
  }
});