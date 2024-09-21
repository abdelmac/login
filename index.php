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
      <?php

        $host = 'localhost';
        $db = 'utilisateurs';
        $user = 'root';
        $password = 'root';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
        

        if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
          $email = $_COOKIE['email'];
          $token = $_COOKIE['token'];

          
      
          // Vérification de l'existence de l'utilisateur
          if ($rep && !empty($rep['email'])) {
            echo $_POST['email'] ;
          } else {
              // Rediriger vers la page de connexion en cas d'échec
              //header("Location: login.php");
              echo " va au login mon reuf";
              //exit();
          }
        } else {
            // Si les cookies ne sont pas définis, rediriger vers la page de connexion
            header("Location: login.php");
            exit();
        }
        

      ?>

      <p><a href="login.php">connect</a></p>
      <p><a href="inscription.php">inscrit toi!</a></p>

      <!-- Display Card of Question And Answers Here -->
      <div id="card-con">
        <div class="card-list-container"></div>
      </div>
    </div>

    <!-- Input form for users to fill question and answer -->
    <form method="POST" action="add_flashcard.php">
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
          name="question"
          placeholder="Type the question here..."
          rows="2"
        ></textarea>
        <label for="answer">Answer:</label>
        <textarea
          class="input"
          id="answer"
          name="answer"
          rows="4"
          placeholder="Type the answer here..."
        ></textarea>
        <button id="save-btn" type="submit">Save</button>
      </div>
    </form>


    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>