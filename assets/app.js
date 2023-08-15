/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './css/app.css';

document.addEventListener("DOMContentLoaded", function() {
    const favoriteButtons = document.querySelectorAll(".favorite-btn");

    favoriteButtons.forEach(button => {
        button.addEventListener("click", function() {
            const eventId = this.getAttribute("data-event-id");
            const isFavorite = this.classList.contains("favorite");

            // Envoyer une requête AJAX au serveur pour mettre à jour l'état de favori
            updateFavoriteStatus(eventId, !isFavorite);
        });
    });

    function updateFavoriteStatus(eventId, newStatus) {
        // Utilisez ici votre bibliothèque AJAX préférée (par exemple, Fetch ou Axios)
        // pour envoyer la requête au contrôleur Symfony qui met à jour l'état de favori.
        // N'oubliez pas de gérer la réponse et de mettre à jour les classes CSS en conséquence.
        // Vous devrez probablement aussi rafraîchir la page ou mettre à jour uniquement l'icône du cœur.
        // Exemple avec Fetch :
        fetch(`/update-favorite/${eventId}/${newStatus}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'état du bouton cœur et son icône
                    const button = document.querySelector(`.favorite-btn[data-event-id="${eventId}"]`);
                    button.classList.toggle("favorite", newStatus);
                    button.querySelector("i").classList.toggle("bi-heart-fill", newStatus);
                    button.querySelector("i").classList.toggle("bi-heart", !newStatus);
                } else {
                    console.error("Erreur lors de la mise à jour de l'état de favori.");
                }
            })
            .catch(error => {
                console.error("Une erreur s'est produite :", error);
            });
    }
});
