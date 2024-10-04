<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

  <p>tu est connecté</p>

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
          if (!empty($email) && !empty($token)) {
            echo $_POST['email'] ;
            echo "t'es connecté frerot";
          } else {
              // Rediriger vers la page de connexion en cas d'échec
              //header("Location: login.php");
              echo " erreur: va au login mon reuf!";
              //exit();
          }
        } else {
            // Si les cookies ne sont pas définis, rediriger vers la page de connexion
            header("Location: login.php");
            echo " erreur: va au login mon reuf mais le 2!";

            exit();
        }
        

      ?>

      <p><a href="login.php">connect</a></p>
      <p><a href="inscription.php">inscrit toi!</a></p>



    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>