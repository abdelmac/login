<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription</title>
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&amp;display=swap" rel="stylesheet">
        <!-- Stylesheet -->
        <style> 
            input {
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>

        <form method="POST" action="traitement.php">
            <label for="nom">Votre nom</label>
            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom ..." required>
            <br />
            
            <label for="prenom">Votre prénom</label>
            <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom..." required>
            <br />
            
            <label for="pseudo">Votre pseudo</label>
            <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo..." required>
            <br />
            
            <label for="email">Votre e-mail</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email..." required>
            <br />
            
            <label for="pass">Votre mot de passe</label>
            <input type="password" id="pass" name="pass" placeholder="Entrez votre mot de passe..." required>
            <br />
            
            <input type="submit" value="M'inscrire" name="ok">
        </form>

    </body>
</html>
