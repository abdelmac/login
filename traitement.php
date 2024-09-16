<?php
$servname = "localhost";
$username = "root";
$password = "root";

try{
    $bdd = new PDO("mysql:host=$servname; dbname=utilisateurs", 
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) );
    //echo "Connexion réussie!;
}

catch(PDOException $e){
    echo "Erreur : ".$e->getMessage();
}

if(isset($_POST['ok'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['pass'];
    $email = $POST['email'];

    $requete = $bdd->prepare("INSERT INTO users VALUES (0, :pseudo , :nom , :prenom , :mdp , :email, '' ");
    $requete->execute(
        array(
            "pseudo" => $pseudo,
            "nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $mdp,
            "email" => $email,

        )
    );
}



?>