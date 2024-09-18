<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>

        <?php
        $servname = "localhost";
        $username = "root";
        $password = "root";
        
        try {
            $bdd = new PDO("mysql:host=$servname;dbname=utilisateurs", $username, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connexion réussie!";
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $error_msg = "";  // Déclarer la variable pour éviter les erreurs undefined

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($email != "" && $password != "") {
                // Génération d'un token de session
                $token = bin2hex(random_bytes(32));

                // Utilisation des requêtes préparées pour éviter les injections SQL
                $req = $bdd->prepare("SELECT id, mdp FROM user WHERE email = :email");
                $req->execute(['email' => $email]);
                $rep = $req->fetch(PDO::FETCH_ASSOC);

                // Vérification de l'utilisateur
                if ($rep && password_verify($password, $rep['mdp'])) {  // Comparaison du mot de passe haché
                    // Mise à jour du token dans la base de données
                    $update = $bdd->prepare("UPDATE user SET token = :token WHERE id = :id");
                    $update->execute(['token' => $token, 'id' => $rep['id']]);

                    // Création des cookies
                    setcookie("token", $token, time() + 3600);
                    setcookie("email", $email, time() + 3600);

                    // Redirection vers la page client
                    header("Location: client.php");
                    exit();
                } else {
                    $error_msg = "Email ou mot de passe incorrect.";
                }
            } else {
                $error_msg = "Veuillez remplir tous les champs.";
            }
        }
        ?>

        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" placeholder="Entrez votre e-mail..." id="email" name="email" required>
            
            <label for="password">Mot de passe</label>
            <input type="password" placeholder="Entrez votre mot de passe..." id="password" name="password" required>
            
            <input type="submit" value="Se connecter" name="ok">
        </form>

        <?php
        // Affichage du message d'erreur
        if (!empty($error_msg)) {
            echo "<p>" . htmlspecialchars($error_msg) . "</p>";
        }
        ?>

    </body>
</html>
