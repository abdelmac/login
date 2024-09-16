<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Login </title>
    </head>
    <body>

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
        

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = $_POST['email'];
            $password = $_POST['password'];
            if($email != "" && $password != ""){
                //connexion a la bdd
                $token = bin2hex(random_bytes(32));


                $req = $bdd->query("SELECT + FROM user WHERE email ='$eamil' AND mdp='$mdp' ");
                $rep = $req->fetch();
                if($rep['id'] != false){
                    $bdd->exec("UPDATE users SET token ='$token' WHERE email='$email' AND mdp= '$password'  ");
                    setcookie("token", $token, time()+3600);
                    setcookie("email", $email, time()+3600);
                    header("location : client.php");
                    exit();
                }
                else{
                    $error_msg = "Email ou mdp faux t'es pas co";
                }
            }
        }

        ?>

        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" placeholder="Entrez votre e-mail ..." id="email" name="email" >
            <label for="password">Mots de passe</label>
            <input type="password" placeholder="Entrez votre e-mail..." id="password" name="password" >
            <input type="submit" value="Se connecter" name="ok">

        </form>

        <?php
        if($error_msg){
            ?>
            <p><?php echo $error_msg; ?></p>
            <?php
        }
        ?>
    </body>
</html>