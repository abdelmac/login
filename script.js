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

  //... rest of your code


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


//Submit Question
cardButton.addEventListener(
  "click",
  (submitQuestion = () => {
    editBool = false;
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
        .then(response => response.text()) // On attend une réponse en texte brut
        .then(data => {
          if (data === "success") {
            alert("Flashcard ajoutée avec succès !");
            // Afficher la carte après l'ajout
            viewlist(tempQuestion, tempAnswer);
            question.value = "";
            answer.value = "";
            container.classList.remove("hide");
          } else {
            alert("Erreur : " + data);  // Affiche le message d'erreur reçu
          }
        })
        .catch(error => {
          console.error("Erreur:", error);
          alert("Une erreur est survenue lors de l'enregistrement de la flashcard.");
        });
    }
  })
);


//Card Generate
function viewlist(questionValue, answerValue) {
  var listCard = document.getElementsByClassName("card-list-container");
  var div = document.createElement("div");
  div.classList.add("card");
  
  //Question
  div.innerHTML += `
  <p class="question-div">${questionValue}</p>`;
  
  //Answer
  var displayAnswer = document.createElement("p");
  displayAnswer.classList.add("answer-div", "hide");
  displayAnswer.innerText = answerValue;

  //Link to show/hide answer
  var link = document.createElement("a");
  link.setAttribute("href", "#");
  link.setAttribute("class", "show-hide-btn");
  link.innerHTML = "Show/Hide";
  link.addEventListener("click", () => {
    displayAnswer.classList.toggle("hide");
  });

  div.appendChild(link);
  div.appendChild(displayAnswer);

  //Edit button
  let buttonsCon = document.createElement("div");
  buttonsCon.classList.add("buttons-con");
  var editButton = document.createElement("button");
  editButton.setAttribute("class", "edit");
  editButton.innerHTML = `<i class="fa-solid fa-pen-to-square"></i>`;
  editButton.addEventListener("click", () => {
    editBool = true;
    modifyElement(editButton, true);
    addQuestionCard.classList.remove("hide");
  });
  buttonsCon.appendChild(editButton);
  disableButtons(false);

  //Delete Button
  var deleteButton = document.createElement("button");
  deleteButton.setAttribute("class", "delete");
  deleteButton.innerHTML = `<i class="fa-solid fa-trash-can"></i>`;
  deleteButton.addEventListener("click", () => {
    modifyElement(deleteButton);
  });
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


// Fonction qui soumet la question et la réponse à add_flashcard.php sans utiliser de JSON
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
  .then(response => response.text())  // On attend une réponse en texte brut
  .then(data => {
    if (data === 'success') {
      alert("Flashcard ajoutée avec succès !");
      viewlist(question, answer);  // Ajouter la nouvelle carte à l'affichage
      // Réinitialiser les champs
      document.getElementById('question').value = '';
      document.getElementById('answer').value = '';
    } else {
      alert("Erreur: " + data);  // Afficher le message d'erreur reçu du serveur
    }
  })
  .catch(error => {
    console.error('Erreur:', error);
    alert("Une erreur est survenue lors de l'ajout de la flashcard.");
  });
});

});
