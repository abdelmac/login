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