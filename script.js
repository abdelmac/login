document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container");
  const addQuestionCard = document.getElementById("add-question-card");
  const cardButton = document.getElementById("save-btn");
  const question = document.getElementById("question");
  const answer = document.getElementById("answer");
  const errorMessage = document.getElementById("error");
  const addQuestion = document.getElementById("add-flashcard");
  const closeBtn = document.getElementById("close-btn");
  let editBool = false;

  

//Add question when user clicks 'Add Flashcard' button
addQuestion.addEventListener("click", () => {
  container.classList.add("hide");
  question.value = "";
  answer.value = "";
  addQuestionCard.classList.remove("hide");
});

//Hide Create flashcard Card
closeBtn.addEventListener(
  "click",
  (hideQuestion = () => {
    container.classList.remove("hide");
    addQuestionCard.classList.add("hide");
    if (editBool) {
      editBool = false;
      submitQuestion();
    }
  })
);

//Hide Create flashcard Card
function hideQuestion() {
  container.classList.remove("hide");
  addQuestionCard.classList.add("hide");
  if (editBool) {
    editBool = false;
    submitQuestion();
  }
}

// Utiliser hideQuestion() ici.
closeBtn.addEventListener("click", hideQuestion);


// Submit Question
cardButton.addEventListener("click", () => {
  let tempQuestion = question.value.trim();
  let tempAnswer = answer.value.trim();

  if (!tempQuestion || !tempAnswer) {
    errorMessage.classList.remove("hide");
  } else {
    errorMessage.classList.add("hide");

    // Envoyer la question et la réponse au serveur via une requête POST
    const formData = new FormData();
    formData.append("question", tempQuestion);
    formData.append("answer", tempAnswer);

    fetch("add_flashcard.php", {
      method: "POST",
      body: formData
    })
      .then(response => response.text())
      .then(data => {
        if (data !== "error") {
          const flashcardId = data;  // L'ID de la flashcard renvoyé par le serveur
          alert("Flashcard ajoutée avec succès !");
          // Appeler la fonction viewlist avec la question, la réponse, et l'ID
          viewlist(tempQuestion, tempAnswer, flashcardId);
          question.value = "";
          answer.value = "";
          container.classList.remove("hide");
        } else {
          alert("Erreur : " + data);
        }
      });
ss    
  }
});



// Fonction pour afficher une nouvelle flashcard
function viewlist(questionValue, answerValue, flashcardId) {
  var listCard = document.getElementsByClassName("card-list-container");
  var div = document.createElement("div");
  div.classList.add("card");

  // Assigne l'ID à la carte
  div.setAttribute('data-id', flashcardId);

  // Question
  div.innerHTML += `<p class="question-div">${questionValue}</p>`;

  // Réponse
  var displayAnswer = document.createElement("p");
  displayAnswer.classList.add("answer-div", "hide");
  displayAnswer.innerText = answerValue;

  // Lien pour afficher/masquer la réponse
  var link = document.createElement("a");
  link.setAttribute("href", "#");
  link.setAttribute("class", "show-hide-btn");
  link.innerHTML = "Show/Hide";
  link.addEventListener("click", () => {
    displayAnswer.classList.toggle("hide");
  });

  div.appendChild(link);
  div.appendChild(displayAnswer);

  // Ajout des boutons Edit et Delete
  let buttonsCon = document.createElement("div");
  buttonsCon.classList.add("buttons-con");

  // Bouton Éditer
  var editButton = document.createElement("button");
  editButton.setAttribute("class", "edit-btn");
  editButton.innerHTML = `<i class="fa-solid fa-pen-to-square"></i>`;
  editButton.addEventListener("click", editFlashcard);  // Ajout de l'événement
  buttonsCon.appendChild(editButton);

  // Bouton Supprimer
  var deleteButton = document.createElement("button");
  deleteButton.setAttribute("class", "delete-btn");
  deleteButton.innerHTML = `<i class="fa-solid fa-trash-can"></i>`;
  deleteButton.addEventListener("click", deleteFlashcard);  // Ajout de l'événement
  buttonsCon.appendChild(deleteButton);

  div.appendChild(buttonsCon);
  listCard[0].appendChild(div); 
  hideQuestion();
}

//Modify Elements
const modifyElement = (element, edit = false) => {
  let parentDiv = element.parentElement.parentElement;
  let parentQuestion = parentDiv.querySelector(".question-div").innerText;
  if (edit) {
    let parentAns = parentDiv.querySelector(".answer-div").innerText;
    answer.value = parentAns;
    question.value = parentQuestion;
    disableButtons(true);
  }
  parentDiv.remove();
};

//Disable edit and delete buttons
const disableButtons = (value) => {
  let editButtons = document.getElementsByClassName("edit");
  Array.from(editButtons).forEach((element) => {
    element.disabled = value;
  });
};


// Fonction pour afficher les flashcards avec un data-id
function viewlist(questionValue, answerValue, flashcardId) {
  var listCard = document.getElementsByClassName("card-list-container");
  var div = document.createElement("div");
  div.classList.add("card");

  // Assigner l'ID à la carte via data-id
  div.setAttribute('data-id', flashcardId);

  // Question
  div.innerHTML += `<p class="question-div">${questionValue}</p>`;

  // Réponse
  var displayAnswer = document.createElement("p");
  displayAnswer.classList.add("answer-div", "hide");
  displayAnswer.innerText = answerValue;

  // Lien pour afficher/masquer la réponse
  var link = document.createElement("a");
  link.setAttribute("href", "#");
  link.setAttribute("class", "show-hide-btn");
  link.innerHTML = "Show/Hide";
  link.addEventListener("click", () => {
    displayAnswer.classList.toggle("hide");
  });

  div.appendChild(link);
  div.appendChild(displayAnswer);

  // Ajouter le div à la liste des cartes
  listCard[0].appendChild(div);
}

// Fonction pour basculer l'affichage des réponses
function toggleAnswer(event) {
  event.preventDefault(); // Empêche le comportement par défaut du lien
  const answer = event.target.previousElementSibling; // Récupère l'élément de réponse associé
  answer.classList.toggle("hide");
}

// Ajoute un écouteur d'événements à tous les boutons "Show/Hide" existants
const showHideButtons = document.querySelectorAll(".show-hide-btn");
showHideButtons.forEach((button) => {
  button.addEventListener("click", toggleAnswer);
});


// Fonction pour éditer une flashcard
function editFlashcard(event) {
  const card = event.target.closest('.card');
  const question = card.querySelector('.question-div').innerText;
  const answer = card.querySelector('.answer-div').innerText;

  // Rendre les champs éditables dans le formulaire
  document.getElementById('question').value = question;
  document.getElementById('answer').value = answer;

  // Changer le comportement du bouton "Save"
  const saveBtn = document.getElementById('save-btn');
  saveBtn.textContent = "Mettre à jour";

  // Mettre à jour la carte lorsque l'utilisateur clique sur "Mettre à jour"
  saveBtn.onclick = function () {
      const newQuestion = document.getElementById('question').value;
      const newAnswer = document.getElementById('answer').value;

      const flashcardId = card.dataset.id; // Récupérer l'ID de la flashcard

      // Envoyer les nouvelles données au serveur via une requête POST
      const formData = new FormData();
      formData.append('id', flashcardId);
      formData.append('question', newQuestion);
      formData.append('answer', newAnswer);

      fetch('edit_flashcard.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.text())
      .then(data => {
          if (data === 'success') {
              alert('Flashcard mise à jour avec succès!');
              card.querySelector('.question-div').innerText = newQuestion;
              card.querySelector('.answer-div').innerText = newAnswer;
              document.getElementById('question').value = '';
              document.getElementById('answer').value = '';
              saveBtn.textContent = "Save";
          } else {
              alert('Erreur lors de la mise à jour.');
          }
      });
  };
}

// Fonction pour supprimer une flashcard
function deleteFlashcard(event) {
const card = event.target.closest('.card');
const flashcardId = card.dataset.id; // Récupérer l'ID de la flashcardzdhuzdj
if (confirm("Are you sure you want to delete this flashcard?")) {
    // Envoyer une requête POST pour supprimer la flashcard
    const formData = new FormData();
    formData.append('data-id', flashcardId);
    
    fetch('delete_flashcard.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            alert('Flashcard supprimée avec succès!');
            card.remove(); // Retirer la carte supprimée du DOM
        } else {
            alert('Erreur lors de la suppression : ' + data);
        }
    })
    .catch(error => console.error('Erreur:', error));
}
}

// Ajout des événements "click" pour les boutons Éditer et Supprimer
document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', editFlashcard);
});

document.querySelectorAll('.delete-btn').forEach((button) => {
    button.addEventListener('click', deleteFlashcard);
});

});


