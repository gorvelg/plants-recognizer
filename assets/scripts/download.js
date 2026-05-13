function initPlantUploadForm() {
    const form = document.querySelector('.form-download');
    const fileInput = document.getElementById('plant_upload_photo');
    const fileName = document.querySelector('.file-name');

    if (!form || !fileInput) {
        return;
    }

    if (fileInput.dataset.listenerAttached === 'true') {
        return;
    }

    fileInput.dataset.listenerAttached = 'true';

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length === 0) {
            return;
        }

        if (fileName) {
            fileName.textContent = fileInput.files[0].name;
        }

        form.requestSubmit();
    });
}

document.addEventListener('turbo:load', initPlantUploadForm);
document.addEventListener('turbo:frame-load', initPlantUploadForm);
