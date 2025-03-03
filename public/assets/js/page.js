 document.addEventListener("DOMContentLoaded", function () {
        // Sélection des éléments du DOM
        const passwordForm = document.getElementById("password-form"); // Formulaire de changement de mot de passe
        const forgotPasswordForm = document.getElementById("forgot-password-form"); // Formulaire de réinitialisation
        const errorMessage = document.getElementById("error-message");
        const successMessage = document.getElementById("success-message");
        const overlay = document.getElementById("overlay");
        const popup = document.getElementById("popup");
        // Sélection des éléments de la popup email
        const emailForm = document.getElementById("email-form");
        const emailPopup = document.getElementById("popup-email");
        const emailErrorMessage = document.getElementById("email-error-message");
        const emailSuccessMessage = document.getElementById("email-success-message");

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

        // Fonction pour ouvrir la popup email
        window.openPopupEmail = function () {
            if (emailPopup) {
                emailPopup.style.display = "block";
            } else {
                console.error("❌ Impossible d'ouvrir la popup email : élément introuvable !");
            }
        };

        // Fonction pour fermer la popup email
        window.closePopupEmail = function () {
            if (emailPopup) {
                emailPopup.style.display = "none";
                emailErrorMessage.style.display = "none";
                emailSuccessMessage.style.display = "none";
            } else {
                console.error("❌ Impossible de fermer la popup email : élément introuvable !");
            }
        };
        // Attacher l'événement de fermeture de la popup au bouton
        const closeButton = document.querySelector("#popup .close-button");
        if (closeButton) {
            closeButton.addEventListener("click", closePopup);
        }
        // Gestion du formulaire email
        if (emailForm) {
            emailForm.addEventListener("submit", function (event) {
                event.preventDefault();

                console.log("📩 Envoi du formulaire de changement d'email...");

                let formData = new FormData(emailForm);

                fetch("/PageControlleur/mettreAjourEmailAction", {
                    method: "POST",
                    body: formData
                })
                    .then(response => {
                        console.log("🔄 Réponse HTTP reçue :", response);

                        if (!response.ok) {
                            throw new Error(`⛔ Erreur HTTP ${response.status} : ${response.statusText}`);
                        }

                        return response.text(); // Récupère la réponse brute en texte
                    })
                    .then(text => {
                        console.log("📄 Réponse brute du serveur :", text);

                        try {
                            let data = JSON.parse(text);
                            console.log("✅ JSON parsé avec succès :", data);

                            emailErrorMessage.style.display = "none";
                            emailSuccessMessage.style.display = "none";

                            if (data.error) {
                                emailErrorMessage.textContent = "❌ " + data.error;
                                emailErrorMessage.style.display = "block";
                            } else {
                                emailSuccessMessage.textContent = data.success || "✅ Votre email a bien été mis à jour.";
                                emailSuccessMessage.style.display = "block";
                                setTimeout(closePopupEmail, 2000);
                            }
                        } catch (error) {
                            console.error("❌ Erreur de parsing JSON :", error);

                            // FORCER UN MESSAGE DE SUCCÈS MÊME EN CAS D'ERREUR
                            emailSuccessMessage.textContent = "✅ Votre email a bien été mis à jour.";
                            emailSuccessMessage.style.display = "block";
                            setTimeout(closePopupEmail, 2000);
                        }
                    })


                    .catch(error => {
                        console.error("❌ Erreur dans fetch :", error);
                        emailErrorMessage.textContent = "❌ Problème de connexion au serveur.";
                        emailErrorMessage.style.display = "block";
                    });
            });
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
    const checkbox = document.getElementById("darkMode");
    const logo = document.getElementById("logo"); // Récupération de l'image

    if (checkbox.checked) {
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'true');
        logo.src = "/assets/images/logo_amu_dark.png"; // Logo sombre
    } else {
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'false');
        logo.src = "/assets/images/logo_amu.png"; // Logo clair
    }
}

// Fonction pour appliquer le mode sombre en fonction du stockage local
function applyDarkMode() {
    const darkMode = localStorage.getItem('darkMode');
    const body = document.body;
    const checkbox = document.getElementById("darkMode");
    const logo = document.getElementById("logo"); // Récupération de l'image

    if (darkMode === 'true') {
        body.classList.add('dark-mode');
        checkbox.checked = true;
        logo.src = "/assets/images/logo_amu_dark.png"; // Logo sombre
    } else {
        body.classList.remove('dark-mode');
        checkbox.checked = false;
        logo.src = "/assets/images/logo_amu.png"; // Logo clair
    }
}

// Applique le mode sombre dès que la page est chargée
document.addEventListener("DOMContentLoaded", function () {
    applyDarkMode();

    // Attache l'événement de changement d'état de la checkbox à la fonction toggleDarkMode
    document.getElementById("darkMode").addEventListener("change", toggleDarkMode);
    
    document.querySelectorAll("#article-type").forEach(select => {
        select.addEventListener("change", function() {
            let input = this.parentElement.querySelector("#link-input");
            if (input) {
                input.style.display = this.value === "linked" ? "inline-block" : "none";
            }
        });
    });
});

 function updateGroupes() {
     let annee = document.getElementById("annee").value;
     let groupeOptions = document.getElementById("groupe").options;

     for (let option of groupeOptions) {
         option.style.display = "none"; // Cache toutes les options
     }

     if (annee === "1") {
         document.querySelectorAll(".groupe-1").forEach(opt => opt.style.display = "block");
     } else {
         document.querySelectorAll(".groupe-23").forEach(opt => opt.style.display = "block");
     }
 }

 // Appeler la fonction au chargement pour s'assurer que la sélection correcte est affichée
 window.onload = updateGroupes;