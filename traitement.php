<?php
$servname = "localhost";
$username = "root";
$password = "root";
$dbname = "utilisateurs";

try {
    // Connexion à la base de données
    $bdd = new PDO("mysql:host=$servname;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie!";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
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

        // Requête SQL pour insérer un utilisateur
        $requete = $bdd->prepare("INSERT INTO users (pseudo, nom, prenom, mdp, email, token) 
                                  VALUES (:pseudo, :nom, :prenom, :mdp, :email, '')");

        // Exécution de la requête avec les paramètres
        $requete->execute([
            "pseudo" => $pseudo,
            "nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $hashed_password,  // Utilisation du mot de passe haché
            "email" => $email
        ]);

        echo "Inscription réussie !";
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}
?>
