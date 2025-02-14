// Fonction pour ouvrir la popup
function openPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

// Fonction pour fermer la popup
function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Intercepter la soumission du formulaire pour ne pas recharger la page
document.getElementById("password-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche la soumission du formulaire et le rechargement de la page

    let formData = new FormData(this); // Collecte les données du formulaire

    // Effectuer la soumission via fetch
    fetch("/PageControlleur/mettreAjourMdpAction", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Réinitialiser les messages d'erreur et de succès
            document.getElementById('error-message').style.display = 'none';
            document.getElementById('success-message').style.display = 'none';

            if (data.error) {
                // Si erreur, afficher le message dans la popup
                document.getElementById('error-message').textContent = data.error;
                document.getElementById('error-message').style.display = 'block';
            } else if (data.success) {
                // Si succès, afficher le message dans la popup
                document.getElementById('success-message').textContent = data.success;
                document.getElementById('success-message').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});