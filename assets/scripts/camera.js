let stream = null;
let isTakingPhoto = false;

document.addEventListener('click', async (event) => {
    const cameraActionBtn = event.target.closest('#camera-action');

    if (!cameraActionBtn || isTakingPhoto) {
        return;
    }

    const cameraPreview = document.querySelector('.camera-capture__preview');
    const video = document.querySelector('#camera-preview');
    const photoCanvas = document.querySelector('#photo-canvas');

    // Si la caméra n'est pas ouverte, on l'ouvre
    if (!stream) {
        const cameraStarted = await startCamera();

        if (cameraStarted) {
            cameraActionBtn.textContent = '';

            cameraActionBtn.classList.remove('camera-capture__button--start');
            cameraActionBtn.classList.add('camera-capture__button--capture');

            if (cameraPreview) {
                cameraPreview.classList.remove('hidden');
            }

            if (photoCanvas) {
                photoCanvas.hidden = true;
                photoCanvas.classList.add('hidden');
            }
        }

        return;
    }

    // Si la caméra est ouverte, on prend la photo
    isTakingPhoto = true;
    cameraActionBtn.disabled = true;

    const photoTaken = await takePhoto();

    cameraActionBtn.disabled = false;
    isTakingPhoto = false;

    if (photoTaken) {
        if (cameraPreview) {
            cameraPreview.classList.add('hidden');
        }

        if (photoCanvas) {
            photoCanvas.hidden = false;
            photoCanvas.classList.remove('hidden');
        }

        stopCamera();

        if (video) {
            video.srcObject = null;
        }

        cameraActionBtn.textContent = '';

        // Important : on garde le style capture
        cameraActionBtn.classList.remove('camera-capture__button--start');
        cameraActionBtn.classList.add('camera-capture__button--capture');
    }
});

async function startCamera() {
    const video = document.querySelector('#camera-preview');

    if (!video) {
        alert("Élément vidéo introuvable.");
        return false;
    }

    if (!window.isSecureContext) {
        alert("La caméra nécessite HTTPS.");
        return false;
    }

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert("getUserMedia n'est pas disponible sur ce navigateur.");
        return false;
    }

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: { ideal: 'environment' }
            },
            audio: false
        });

        video.srcObject = stream;
        video.setAttribute('playsinline', true);

        await video.play();

        console.log('Caméra démarrée');
        return true;
    } catch (error) {
        stream = null;

        console.error(error);

        alert(
            "Impossible d'accéder à la caméra.\n\n" +
            error.name + "\n" +
            error.message
        );

        return false;
    }
}

function takePhoto() {
    return new Promise((resolve) => {
        const video = document.querySelector('#camera-preview');
        const canvas = document.querySelector('#photo-canvas');

        const photoInput =
            document.getElementById('photo-input') ||
            document.getElementById('plant_upload_photo');

        if (!stream) {
            alert("La caméra n'est pas encore ouverte.");
            resolve(false);
            return;
        }

        if (!video || !canvas || !photoInput) {
            alert("Il manque video, canvas ou l'input file.");
            resolve(false);
            return;
        }

        const maxWidth = 1200;

        const originalWidth = video.videoWidth;
        const originalHeight = video.videoHeight;

        if (!originalWidth || !originalHeight) {
            alert("La vidéo n'est pas encore prête.");
            resolve(false);
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
                resolve(false);
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

            console.log('Photo ajoutée dans le champ file:', photoInput.files[0]);

            resolve(true);
        }, 'image/jpeg', 0.75);
    });
}

function stopCamera() {
    if (!stream) {
        return;
    }

    stream.getTracks().forEach((track) => {
        track.stop();
    });

    stream = null;

    console.log('Caméra arrêtée');
}
