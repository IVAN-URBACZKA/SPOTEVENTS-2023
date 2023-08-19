// any CSS you import will output into a single css file (app.css in this case)
import './css/app.css';

document.addEventListener("DOMContentLoaded", function() {
    const favoriteButtons = document.querySelectorAll(".favorite-btn");

    favoriteButtons.forEach(button => {
        const eventId = button.getAttribute("data-event-id");
        const favoriteStateKey = `favorite_state_${eventId}`;
        const isFavorite = localStorage.getItem(favoriteStateKey) === "true";

        button.classList.toggle("favorite", isFavorite);
        button.querySelector("i").classList.toggle("bi-heart-fill", isFavorite);
        button.querySelector("i").classList.toggle("bi-heart", !isFavorite);

        button.addEventListener("click", function() {
            const eventId = this.getAttribute("data-event-id");
            const isFavorite = this.classList.contains("favorite");

            updateFavoriteStatus(eventId, !isFavorite);
        });
    });

    function updateFavoriteStatus(eventId, newStatus) {
        fetch(`/update-favorite/${eventId}/${newStatus}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const button = document.querySelector(`.favorite-btn[data-event-id="${eventId}"]`);
                    const isFavorite = newStatus;
    
                    button.classList.toggle("favorite", isFavorite);
                    button.querySelector("i").classList.toggle("bi-heart-fill", isFavorite);
                    button.querySelector("i").classList.toggle("bi-heart", !isFavorite);
    
                    // Enregistrement de l'état de favori dans le localStorage
                    const favoriteStateKey = `favorite_state_${eventId}`;
                    localStorage.setItem(favoriteStateKey, isFavorite);
                } else {
                    console.error("Erreur lors de la mise à jour de l'état de favori.");
                }
            })
            .catch(error => {
                console.error("Une erreur s'est produite :", error);
            });
    }
    
});
