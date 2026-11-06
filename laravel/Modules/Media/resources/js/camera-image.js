/**
 * Browser-side normalisation of photos taken with a mobile camera, before Livewire uploads them.
 *
 * A camera photo weighs 3-8 MB and the production server accepts 2 MB per request (nginx + PHP, see
 * Modules/Media/docs/stories/media-mobile-camera-upload.story.md). Images over 1 MB are re-encoded as JPEG with
 * the long side at `CameraPhotoUpload::MAX_SIDE` (1920 px, passed by the caller); HEIC/HEIF (desktop, Android) becomes JPEG first. The server strips EXIF/GPS anyway,
 * so nothing it keeps is lost here.
 *
 * Used by any upload client that calls `$wire.upload()` itself (e.g. Fixcity `dc-file-upload`).
 * The theme bundles this file through the `@modules` alias.
 */
const MEGABYTE = 1024 * 1024;

export function isCameraFormat(file) {
    return ['image/heic', 'image/heif'].includes((file.type || '').toLowerCase()) || /\.(heic|heif)$/i.test(file.name || '');
}

function renamed(name, extension) {
    return name.replace(/\.[^.]+$/, '') + extension;
}

async function heicToJpeg(file) {
    // ~1 MB converter, loaded only when a HEIC file is actually picked
    const { default: heic2any } = await import('heic2any');
    const converted = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.9 });
    const blob = Array.isArray(converted) ? converted[0] : converted;
    if (!(blob instanceof Blob)) {
        throw new Error('HEIC conversion did not return an image blob.');
    }

    return new File([blob], renamed(file.name, '.jpg'), { type: 'image/jpeg', lastModified: file.lastModified });
}

async function toResizedJpeg(file, maxSide, quality) {
    const source = URL.createObjectURL(file);
    const canvas = document.createElement('canvas');
    try {
        const image = new Image();
        image.src = source;
        await image.decode();

        // naturalWidth/Height already honour the EXIF orientation (image-orientation: from-image)
        const scale = Math.min(1, maxSide / Math.max(image.naturalWidth, image.naturalHeight));
        canvas.width = Math.round(image.naturalWidth * scale);
        canvas.height = Math.round(image.naturalHeight * scale);
        const context = canvas.getContext('2d');
        if (!context || !canvas.width || !canvas.height) return null;
        context.fillStyle = '#fff';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.drawImage(image, 0, 0, canvas.width, canvas.height);

        const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', quality));
        if (!(blob instanceof Blob)) return null;

        return new File([blob], renamed(file.name, '.jpg'), { type: 'image/jpeg', lastModified: file.lastModified });
    } catch {
        return null;
    } finally {
        URL.revokeObjectURL(source);
        // old iPhones keep the bitmap alive until the canvas shrinks
        canvas.width = 0;
        canvas.height = 0;
    }
}

/**
 * @param {File} file
 * @param {{ maxSide?: number, quality?: number, threshold?: number }} [options]
 * @returns {Promise<File|null>} the file to upload, or null when a HEIC file cannot be decoded
 */
export async function normalize(file, { maxSide = 1920, quality = 0.85, threshold = MEGABYTE } = {}) {
    let image = file;
    if (isCameraFormat(file)) {
        try {
            image = await heicToJpeg(file);
        } catch {
            // Safari 17+ decodes HEIC natively: the canvas below tries
        }
    }

    const mustEncode = isCameraFormat(image);
    if (!mustEncode && !(image.type.startsWith('image/') && image.size > threshold)) return image;

    const resized = await toResizedJpeg(image, maxSide, quality);
    if (mustEncode) return resized;

    return resized && resized.size < image.size ? resized : image;
}

window.MediaCameraImage = { isCameraFormat, normalize };
