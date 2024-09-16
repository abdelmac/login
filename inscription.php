<!DOCTYPE html>
<htm>
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
            input{
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>

        <form method="POST" action="traitement.php">
            <label for="nom" > Votre nom </label>
            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom ...">
            <br />
            <label for="nom" > Votre prenom </label>
            <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prenom...">
            <br />
            <label for="nom" > Votre pseudo </label>
            <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo...">
            <br />
            <label for="nom" > Votre e-mail </label>
            <input type="text" id="email" name="email" placeholder="Entrez votre email...">
            <br />
            <label for="nom" > Votre pass </label>
            <input type="password" id="pass" name="pass" placeholder="Entrez votre mots de passe...">
            <br />
            <input type="submit" value="M'inscrire" name="ok">
        </form>

    </body>
</htm>