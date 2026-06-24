let stream = null;

document.addEventListener('click', async (event) => {
    const startCameraBtn = event.target.closest('#start-camera');
    const takePhotoBtn = event.target.closest('#take-photo');

    if (startCameraBtn) {
        await startCamera();
    }

    if (takePhotoBtn) {
        takePhoto();
    }
});

async function startCamera() {
    const video = document.querySelector('#camera-preview');

    if (!video) {
        alert("Élément vidéo introuvable.");
        return;
    }

    if (!window.isSecureContext) {
        alert("La caméra nécessite HTTPS.");
        return;
    }

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert("getUserMedia n'est pas disponible sur ce navigateur.");
        return;
    }

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: { ideal: 'environment' }
            },
            audio: false
        });

        video.srcObject = stream;
        await video.play();

        console.log('Caméra démarrée');
    } catch (error) {
        console.error(error);

        alert(
            "Impossible d'accéder à la caméra.\n\n" +
            error.name + "\n" +
            error.message
        );
    }
}

function takePhoto() {
    const video = document.querySelector('#camera-preview');
    const canvas = document.querySelector('#photo-canvas');
    const photoInput = document.getElementById('plant_upload_photo');

    if (!stream) {
        alert("La caméra n'est pas encore ouverte.");
        return;
    }

    if (!video || !canvas || !photoInput) {
        alert("Il manque video, canvas ou l'input file #photo-input.");
        return;
    }

    const maxWidth = 1200;

    const originalWidth = video.videoWidth;
    const originalHeight = video.videoHeight;

    if (!originalWidth || !originalHeight) {
        alert("La vidéo n'est pas encore prête.");
        return;
    }

    const ratio = originalHeight / originalWidth;
    const width = Math.min(originalWidth, maxWidth);
    const height = Math.round(width * ratio);

    canvas.width = width;
    canvas.height = height;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, width, height);

    canvas.toBlob((blob) => {
        if (!blob) {
            alert("Impossible de créer l'image.");
            return;
        }

        const file = new File([blob], 'photo.jpg', {
            type: 'image/jpeg',
            lastModified: Date.now()
        });

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        photoInput.files = dataTransfer.files;
        photoInput.dispatchEvent(new Event('change', { bubbles: true }));

    }, 'image/jpeg', 0.75);
}
