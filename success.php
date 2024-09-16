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
    echo $_POST['pseudo'] ;
}




?>