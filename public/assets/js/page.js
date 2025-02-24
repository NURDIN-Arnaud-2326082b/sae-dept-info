/*// Fonction pour ouvrir la popup
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

*/


document.addEventListener("DOMContentLoaded", function () {
    // Sélection des éléments du DOM
    const passwordForm = document.getElementById("password-form"); // Formulaire de changement de mot de passe
    const forgotPasswordForm = document.getElementById("forgot-password-form"); // Formulaire de réinitialisation
    const errorMessage = document.getElementById("error-message");
    const successMessage = document.getElementById("success-message");
    const overlay = document.getElementById("overlay");
    const popup = document.getElementById("popup");

    // Fonction pour ouvrir la popup
    function openPopup() {
        if (popup) {
            popup.style.display = 'block';
            overlay.style.display = 'block';
        }
    }

    // Fonction pour fermer la popup
    function closePopup() {
        if (popup) {
            popup.style.display = 'none';
            overlay.style.display = 'none';
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';
        }
    }

    // Attacher l'événement de fermeture de la popup au bouton
    const closeButton = document.querySelector("#popup .close-button");
    if (closeButton) {
        closeButton.addEventListener("click", closePopup);
    }

    // Vérifier si le formulaire de changement de mot de passe est sur la page
    if (passwordForm) {
        passwordForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Empêche le rechargement de la page

            let formData = new FormData(this);

            fetch("/PageControlleur/mettreAjourMdpAction", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    errorMessage.style.display = 'none';
                    successMessage.style.display = 'none';

                    if (data.error) {
                        errorMessage.textContent = data.error;
                        errorMessage.style.display = 'block';
                    } else if (data.success) {
                        successMessage.textContent = data.success;
                        successMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        });
    }

    // Vérifier si le formulaire de réinitialisation du mot de passe est sur la page
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Empêche le rechargement de la page

            let formData = new FormData(this);

            fetch("/PageControlleur/reinitialiserMdpAction", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    errorMessage.style.display = 'none';
                    successMessage.style.display = 'none';

                    if (data.error) {
                        errorMessage.textContent = data.error;
                        errorMessage.style.display = 'block';
                    } else if (data.success) {
                        successMessage.textContent = data.success;
                        successMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        });
    }

    // Rendre openPopup accessible globalement pour être appelée depuis un bouton
    window.openPopup = openPopup;
    window.closePopup = closePopup;
});


// Fonction pour basculer entre le mode sombre et clair
function toggleDarkMode() {
    // Récupère l'élément body ou l'élément global du site
    const body = document.body;

    // Vérifie si le mode sombre est déjà activé
    if (body.classList.contains('dark-mode')) {
        // Désactive le mode sombre
        body.classList.remove('dark-mode');
        // Enregistre la préférence comme étant le mode clair
        localStorage.setItem('darkMode', 'false');
        document.getElementById("dark-mode-toggle").textContent = "Mode Sombre";
    } else {
        // Active le mode sombre
        body.classList.add('dark-mode');
        // Enregistre la préférence comme étant le mode sombre
        localStorage.setItem('darkMode', 'true');
        document.getElementById("dark-mode-toggle").textContent = "Mode Clair";
    }
}

// Fonction pour appliquer le mode sombre en fonction du stockage local
function applyDarkMode() {
    // Vérifie si le mode sombre est activé dans localStorage
    const darkMode = localStorage.getItem('darkMode');
    const body = document.body;

    // Si la préférence est stockée et vaut 'true', active le mode sombre
    if (darkMode === 'true') {
        body.classList.add('dark-mode');
        document.getElementById("dark-mode-toggle").textContent = "Mode Clair";
    } else {
        body.classList.remove('dark-mode');
        document.getElementById("dark-mode-toggle").textContent = "Mode Sombre";
    }
}

// Applique le mode sombre dès que la page est chargée
window.onload = applyDarkMode;

