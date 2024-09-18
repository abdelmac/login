<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcard App</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <div class="add-flashcard-con">
        <button id="add-flashcard">Add Flashcard 2</button>
      </div>
      <p><a href="login.php">connect</a></p>
      <p><a href="inscription.php">inscrit toi!</a></p>

      <!-- Display Card of Question And Answers Here -->
      <div id="card-con">
        <div class="card-list-container"></div>
      </div>
    </div>

    <!-- Input form for users to fill question and answer -->
    <div class="question-container hide" id="add-question-card">
      <h2>Add Flashcard</h2>
      <div class="wrapper">
        <!-- Error message -->
        <div class="error-con">
          <span class="hide" id="error">Input fields cannot be empty!</span>
        </div>
        <!-- Close Button -->
        <i class="fa-solid fa-xmark" id="close-btn"></i>
      </div>

      <label for="question">Question:</label>
      <textarea
        class="input"
        id="question"
        placeholder="Type the question here..."
        rows="2"
      ></textarea>
      <label for="answer">Answer:</label>
      <textarea
        class="input"
        id="answer"
        rows="4"
        placeholder="Type the answer here..."
      ></textarea>
      <button id="save-btn">Save</button>
    </div>

    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>