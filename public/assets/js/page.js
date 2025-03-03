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
    const dlpopup = document.getElementById("dlpopup");

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

        let isSubmitting = false;

        forgotPasswordForm.addEventListener("submit", function (event) {
            event.preventDefault();
            if (isSubmitting) return;

            isSubmitting = true;

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;



            let formData = new FormData(this);

            fetch("/PageControlleur/reinitialiserMdp", {
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
                })
                .finally(() => {
                    submitButton.disabled = false;
                    isSubmitting = false;
                });
        });
    }


    // Rendre openPopup accessible globalement pour être appelée depuis un bouton
    window.openPopup = openPopup;
    window.closePopup = closePopup;
});


// afficher ou masquer le mot de passe
document.addEventListener("DOMContentLoaded", function () {
    console.log("Script chargé !");

    const toggleButtons = document.querySelectorAll(".toggle-password");

    toggleButtons.forEach(button => {
        // Vérifiez si l'événement est déjà attaché
        if (button.getAttribute("data-listener-attached") !== "true") {
            console.log("Bouton détecté :", button);

            button.addEventListener("click", function (event) {
                event.preventDefault(); // Empêche un éventuel rechargement ou comportement inattendu
                event.stopPropagation(); // Stoppe la propagation de l'événement

                const targetId = this.getAttribute("data-target");
                console.log("Cible du bouton :", targetId);

                const passwordInput = document.getElementById(targetId);
                if (!passwordInput) {
                    console.error("Erreur : Impossible de trouver le champ de mot de passe avec l'ID :", targetId);
                    return;
                }

                console.log("Type de l'input avant changement :", passwordInput.type);

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.textContent = "🙈";
                    console.log("Mot de passe affiché !");
                } else {
                    passwordInput.type = "password";
                    this.textContent = "👁️";
                    console.log("Mot de passe caché !");
                }

                console.log("Type de l'input après changement :", passwordInput.type);
            });

            // Marquez le bouton comme ayant déjà un écouteur d'événement
            button.setAttribute("data-listener-attached", "true");
        }
    });
});

// Fonction pour basculer entre le mode sombre et clair
function toggleDarkMode() {
    const body = document.body;
    const toggleButton = document.getElementById("dark-mode-toggle");
    const checkbox = document.getElementById("darkMode"); // L'élément checkbox

    // Vérifie si le mode sombre est déjà activé
    if (body.classList.contains('dark-mode')) {
        // Désactive le mode sombre
        body.classList.remove('dark-mode');
        // Enregistre la préférence comme étant le mode clair
        localStorage.setItem('darkMode', 'false');
        toggleButton.textContent = "Mode Sombre"; // Texte du bouton
        checkbox.checked = false; // Décoche la checkbox
    } else {
        // Active le mode sombre
        body.classList.add('dark-mode');
        // Enregistre la préférence comme étant le mode sombre
        localStorage.setItem('darkMode', 'true');
        toggleButton.textContent = "Mode Clair"; // Texte du bouton
        checkbox.checked = true; // Coche la checkbox
    }
}

// Fonction pour appliquer le mode sombre en fonction du stockage local
function applyDarkMode() {
    const darkMode = localStorage.getItem('darkMode');
    const body = document.body;
    const toggleButton = document.getElementById("dark-mode-toggle");
    const checkbox = document.getElementById("darkMode");

    // Si la préférence est stockée et vaut 'true', active le mode sombre
    if (darkMode === 'true') {
        body.classList.add('dark-mode');
        toggleButton.textContent = "Mode Clair"; // Texte du bouton
        checkbox.checked = true; // Coche la checkbox
    } else {
        body.classList.remove('dark-mode');
        toggleButton.textContent = "Mode Sombre"; // Texte du bouton
        checkbox.checked = false; // Décoche la checkbox
    }
}

// Applique le mode sombre dès que la page est chargée
window.onload = applyDarkMode;

// Attache l'événement de changement d'état de la checkbox à la fonction toggleDarkMode
document.getElementById("darkMode").addEventListener("change", toggleDarkMode);

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#article-type").forEach(select => {
        select.addEventListener("change", function() {
            let input = this.parentElement.querySelector("#link-input");
            if (input) {
                input.style.display = this.value === "linked" ? "inline-block" : "none";
            }
        });
    });
});

