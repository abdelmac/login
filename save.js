document.addEventListener('DOMContentLoaded', () => {
    const cardButton = document.getElementById("save-btn");
    const question = document.getElementById("question");
    const answer = document.getElementById("answer");

    // Gestion du bouton "Save" pour ajouter une nouvelle flashcard
    cardButton.addEventListener('click', function (event) {
        event.preventDefault(); // Empêche la soumission par défaut du formulaire

        const questionValue = question.value.trim();
        const answerValue = answer.value.trim();

        // Validation des champs question et réponse
        if (!questionValue || !answerValue) {
            alert("Les champs question et réponse ne peuvent pas être vides.");
            return; // Arrêter l'exécution si validation échoue
        }

        // Désactiver temporairement le bouton pour éviter les double clics
        cardButton.disabled = true;

        // Envoyer les données au serveur via fetch
        fetch('add_flashcard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'question': questionValue,
                'answer': answerValue
            })
        })
        .then(response => response.json())  // S'attend à une réponse JSON
        .then(data => {
            if (data.status === 'success') {
                alert("Flashcard ajoutée avec succès !");
                viewlist(data.id, questionValue, answerValue);  // Ajouter la nouvelle carte à l'affichage
                question.value = '';  // Réinitialiser les champs
                answer.value = '';
            } else {
                alert("Erreur: " + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Une erreur est survenue lors de l'ajout de la flashcard.");
        })
        .finally(() => {
            cardButton.disabled = false; // Réactiver le bouton après l'ajout
        });
    });

    // Fonction pour afficher la liste des flashcards dynamiquement
    function viewlist(id, question, answer) {
        const cardList = document.getElementById('flashcard-list'); // Conteneur des flashcards
        const card = document.createElement('div');
        card.className = 'flashcard';
        card.setAttribute('data-id', id);
        card.innerHTML = `
            <p>ID: ${id}</p>
            <p>Question: ${question}</p>
            <p class="answer" style="display:none;">${answer}</p> <!-- La réponse masquée -->
            <button class="show-answer-btn">Voir la réponse</button>
            <button class="delete-btn">Supprimer</button>
        `;
        cardList.appendChild(card); // Ajouter la carte
    }

    // Délégation d'événement pour la gestion des boutons "Voir la réponse" et "Supprimer"
    document.getElementById('flashcard-list').addEventListener('click', function(event) {
        const target = event.target;

        // Gestion de l'affichage de la réponse
        if (target.classList.contains('show-answer-btn')) {
            const card = target.closest('.flashcard');
            const answerElement = card.querySelector('.answer');
            if (answerElement.style.display === 'none' || !answerElement.style.display) {
                answerElement.style.display = 'block';  // Afficher la réponse
                target.textContent = "Masquer la réponse";  // Changer le texte du bouton
            } else {
                answerElement.style.display = 'none';  // Masquer la réponse
                target.textContent = "Voir la réponse";  // Remettre le texte d'origine
            }
        }

        // Gestion de la suppression de la carte
        if (target.classList.contains('delete-btn')) {
            const card = target.closest('.flashcard');
            const flashcardId = card.getAttribute('data-id');
            if (confirm("Voulez-vous vraiment supprimer cette flashcard ?")) {
                deleteFlashcard(flashcardId, card);  // Suppression
            }
        }
    });

    // Fonction pour supprimer une flashcard
    function deleteFlashcard(id, cardElement) {
        fetch('delete_flashcard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'id': id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                cardElement.remove(); // Supprimer la flashcard du DOM
            } else {
                alert("Erreur lors de la suppression de la flashcard.");
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
});
