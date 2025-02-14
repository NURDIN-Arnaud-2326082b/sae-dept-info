// Définis la séquence du Konami Code
const konamiCode = [
    'arrowup', 'arrowup', 'arrowdown', 'arrowdown',
    'arrowleft', 'arrowright', 'arrowleft', 'arrowright', 'b', 'a'
];

let input = []; // Tableau pour stocker les touches pressées

// Écoute les événements de touches
document.addEventListener('keydown', (event) => {
    // Ajouter la touche pressée en minuscule au tableau
    input.push(event.key.toLowerCase());

    // Limite la taille de l'entrée au nombre de touches du Konami Code
    if (input.length > konamiCode.length) {
        input.shift(); // Supprimer le premier élément si nécessaire
    }

    // Vérifie si l'entrée correspond au Konami Code
    if (input.join(',') === konamiCode.join(',')) {
        triggerEasterEgg();
        input = []; // Réinitialiser l'entrée après activation
    }
});

function triggerEasterEgg() {
    createBlinkingImages();
}

function createBlinkingImages() {
    const container = document.createElement('div');
    container.style.position = 'fixed';
    container.style.top = '50%';
    container.style.left = '50%';
    container.style.transform = 'translate(-50%, -50%)';
    container.style.display = 'flex'; // Aligner horizontalement
    container.style.gap = '20px'; // Espacement entre les images
    container.style.zIndex = '1000';

    // Ajouter la première image
    const img1 = document.createElement('img');
    img1.src = '/assets/images/egg/baby_egg.png';
    img1.style.width = '500px';
    img1.style.animation = 'blink 0.1s infinite';
    container.appendChild(img1);

    // Ajouter la deuxième image
    const img2 = document.createElement('img');
    img2.src = '/assets/images/egg/baby_egg2.jpg';
    img2.style.width = '500px';
    img2.style.animation = 'blink 0.1s infinite';
    container.appendChild(img2);

    document.body.appendChild(container);

    // Supprimer après 5 secondes
    setTimeout(() => {
        container.remove();
    }, 1000);
}

// Ajouter l'animation clignotante au CSS
const style = document.createElement('style');
style.textContent = `
  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
  }
`;
document.head.appendChild(style);

