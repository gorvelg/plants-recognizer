const form = document.querySelector('.form-download');
const fileInput = document.getElementById('plant_upload_photo');
const fileName = document.querySelector('.file-name');

if (form && fileInput) {
    fileInput.addEventListener('change', () => {
        if (fileName && fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        }

        if (fileInput.files.length > 0) {
            form.requestSubmit();
        }
    });
}
