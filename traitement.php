<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$user = 'root';
$password = 'root';
$db = 'utilisateurs';
$host = 'localhost';

try {
    // Connexion à la base de données
    $bdd = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie!";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit(); // Arrête l'exécution si la connexion échoue
}

if (isset($_POST['ok'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['pass'];
    $email = $_POST['email'];

    // Vérification que tous les champs sont remplis
    if (!empty($nom) && !empty($prenom) && !empty($pseudo) && !empty($mdp) && !empty($email)) {
        
        // Hachage du mot de passe
        $hashed_password = password_hash($mdp, PASSWORD_BCRYPT);

        // Génération d'un token aléatoire
        $token = bin2hex(random_bytes(16));

        // Requête SQL pour insérer un utilisateur (sans la colonne 'id', qui est auto-incrémentée)
        $requete = $bdd->prepare("INSERT INTO users (pseudo, nom, prenom, mdp, email, token) 
                                  VALUES (:pseudo, :nom, :prenom, :mdp, :email, :token)");

        // Exécution de la requête avec les paramètres
        if ($requete->execute([
            "pseudo" => $pseudo,
            "nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $hashed_password,  // Utilisation du mot de passe haché
            "email" => $email,
            "token" => $token
        ])) {
            echo "Inscription réussie !";
        } else {
            echo "Erreur lors de l'inscription.";
        }

    } else {
        echo "Tous les champs doivent être remplis.";
    }
}
?>
