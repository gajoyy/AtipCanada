const passportDropzone = document.getElementById('passport-dropzone');
const passportFileInput = document.getElementById('passport_file');
const passportDropzoneText = passportDropzone.querySelector('.dropzone-text');

const visaDropzone = document.getElementById('visa-dropzone');
const visaFileInput = document.getElementById('visa_file');
const visaDropzoneText = visaDropzone.querySelector('.dropzone-text');

function setupDropzone(dropzone, fileInput, dropzoneText) {
    dropzone.addEventListener('click', () => {
        console.log('Dropzone clicked');
        fileInput.click();
    });

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        console.log('File dragged over dropzone');
        dropzone.classList.add('hover');
    });

    dropzone.addEventListener('dragleave', () => {
        console.log('File left dropzone');
        dropzone.classList.remove('hover');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        console.log('File dropped into dropzone');
        dropzone.classList.remove('hover');
        const files = e.dataTransfer.files;
        console.log('Dropped files:', files);
        fileInput.files = files;
        updateDropzoneText(dropzoneText, files);
    });

    fileInput.addEventListener('change', () => {
        console.log('File input changed');
        updateDropzoneText(dropzoneText, fileInput.files);
    });
}

setupDropzone(passportDropzone, passportFileInput, passportDropzoneText);
setupDropzone(visaDropzone, visaFileInput, visaDropzoneText);

function updateDropzoneText(dropzoneText, files) {
    if (files.length > 0) {
        dropzoneText.textContent = `${files.length} arquivo(s) selecionado(s)`;
        console.log(`${files.length} arquivo(s) selecionado(s)`);
    } else {
        dropzoneText.textContent = 'Arraste e solte os arquivos aqui ou clique para selecionar';
    }
}

const menuButton = document.getElementById("menu-hamburguer");
const menu = document.getElementById("menu");

menuButton.addEventListener("click", function () {
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
});

window.addEventListener("resize", function () {
    if (window.innerWidth > 768) { 
        menu.style.display = "none";
    }
});
