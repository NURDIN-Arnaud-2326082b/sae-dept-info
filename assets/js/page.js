function toggleImageUpload(type) {
    const imageUpload = document.getElementById('image-upload');
    if (type === 'img') {
        imageUpload.style.display = 'block';
    } else {
        imageUpload.style.display = 'none';
    }
}