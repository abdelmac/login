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

        
        try{
            $bdd = new PDO("mysql:host=$host; dbname=$db", 
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) );
            //echo "Connexion réussie!;
        }
        
        catch(PDOException $e){
            echo "Erreur : ".$e->getMessage();
        }


        $email = $_COOKIE['email'];
        $token = $_COOKIE['token'];

        if($token){
            $req = $bdd->query("SELECT * FROM users WHERE email = '$email' AND token = '$token' ");
            $rep = $req->fetch();

            if($rep['pseudo'] != false){
                echo "vous etes co ". $rep['pseudo']." ! ";
            }
            else{
                header("location: login.php");
            }
        }    
?>