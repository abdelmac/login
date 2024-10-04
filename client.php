<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$user = 'root';  // Utilisateur MySQL
$password = 'root';  // Mot de passe MySQL
$db = 'utilisateurs';  // Nom de la base de données
$host = 'localhost';  // Hôte du serveur MySQL

try {
    // Connexion à la base de données
    $bdd = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    // Configuration des attributs PDO pour afficher les erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie!";
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher un message d'erreur
    echo "Erreur : " . $e->getMessage();
    exit();  // Sortir en cas d'échec de la connexion
}

// Vérification des cookies 'email' et 'token'
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    // Utilisation de requêtes préparées pour sécuriser les données
    $req = $bdd->prepare("SELECT pseudo FROM users WHERE email = :email AND token = :token");
    $req->execute(['email' => $email, 'token' => $token]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);

    // Vérification de l'existence de l'utilisateur
    if ($rep && !empty($rep['pseudo'])) {
        echo "Vous êtes connecté, " . htmlspecialchars($rep['pseudo']) . " !";
    } else {
        // Rediriger vers la page de connexion en cas d'échec
        header("Location: login.php");
        exit();
    }
} else {
    // Si les cookies ne sont pas définis, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>
