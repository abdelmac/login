const container = document.querySelector(".container");
const addQuestionCard = document.getElementById("add-question-card");
const cardButton = document.getElementById("save-btn");
const question = document.getElementById("question");
const answer = document.getElementById("answer");
const errorMessage = document.getElementById("error");
const addQuestion = document.getElementById("add-flashcard");
const closeBtn = document.getElementById("close-btn");
let editBool = false;




document.getElementById('save-btn').addEventListener('click', function (event) {
    event.preventDefault(); // Empêche la soumission par défaut du formulaire
  
    const question = document.getElementById('question').value.trim();
    const answer = document.getElementById('answer').value.trim();
  
    // Validation des champs question et réponse
    if (!question || !answer) {
      alert("Les champs question et réponse ne peuvent pas être vides.");
      return; // Arrêter l'exécution si validation échoue
    }
  
    // Envoyer les données au serveur via fetch
    fetch('add_flashcard.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'question': question,
        'answer': answer
      })
    })
    .then(response => {
      // Vérifier si la réponse est du JSON valide
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
        return response.json();
      } else {
        throw new Error("Réponse non JSON reçue");
      }
    })
    .then(data => {
      if (data.status === 'success') {
        alert("Flashcard ajoutée avec succès !");
        viewlist(question, answer);  // Ajouter la nouvelle carte à l'affichage
        // Réinitialiser les champs
        document.getElementById('question').value = '';
        document.getElementById('answer').value = '';
      } else {
        alert("Erreur: " + data.message);
      }
    })
    .catch(error => {
      console.error('Erreur:', error);
      alert("Une erreur est survenue lors de l'ajout de la flashcard.");
    });
  });
  