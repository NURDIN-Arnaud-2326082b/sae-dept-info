function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.querySelector('.modal');
    if (event.target == modal) {
        closeModal('modal1');
    }
}
