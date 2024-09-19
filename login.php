<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$user = 'root';  // Remplace par ton utilisateur MySQL
$password = 'root';  // Remplace par ton mot de passe MySQL
$db = 'utilisateurs';  // Nom de ta base de données
$host = 'localhost';  // Hôte du serveur MySQL

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit();  // Sortir en cas d'erreur de connexion
}

$error_msg = "";  // Variable pour stocker les messages d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Génération d'un token de session sécurisé
        $token = bin2hex(random_bytes(32));

        // Utilisation des requêtes préparées pour sécuriser les données
        $req = $bdd->prepare("SELECT id, mdp FROM users WHERE email = :email");
        $req->execute(['email' => $email]);
        $rep = $req->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur existe et que le mot de passe est correct
        if ($rep && password_verify($password, $rep['mdp'])) {
            // Mise à jour du token dans la base de données
            $update = $bdd->prepare("UPDATE users SET token = :token WHERE id = :id");
            $update->execute(['token' => $token, 'id' => $rep['id']]);

            // Création des cookies sécurisés pour la session
            setcookie("token", $token, time() + 3600);
            setcookie("email", $email, time() + 3600);

            // Redirection vers la page client
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Email ou mot de passe incorrect.";
        }
    } else {
        $error_msg = "Veuillez remplir tous les champs.";
    }
}
?>

<!-- Formulaire de connexion -->
<form method="POST" action="">
    <label for="email">Email</label>
    <input type="email" placeholder="Entrez votre e-mail..." id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <input type="password" placeholder="Entrez votre mot de passe..." id="password" name="password" required>

    <input type="submit" value="Se connecter" name="ok">
</form>

<?php
// Affichage du message d'erreur s'il existe
if (!empty($error_msg)) {
    echo "<p>" . htmlspecialchars($error_msg) . "</p>";
}
?>

</body>
</html>
