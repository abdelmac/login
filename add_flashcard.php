<?php
session_start();
include 'db.php';  // Connexion à la base de données

$conn = new mysqli($host, $user, $password, $db);

// Fonction pour vérifier l'utilisateur via le token et l'email
function verifyUser($conn, $email, $token) {
    $stmt = $conn->prepare("SELECT token FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($dbToken);
    $stmt->fetch();
    $stmt->close();
    
    // Vérifier si le token stocké en base de données correspond à celui fourni
    return ($dbToken === $token);
}

// Vérifier si les cookies sont définis (authentification)
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    // Vérifier la validité des cookies dans la base de données
    if (verifyUser($conn, $email, $token)) {
        // Si les cookies sont valides, vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire (question et réponse)
            $question = trim($_POST['question']);
            $answer = trim($_POST['answer']);

            // Validation des champs
            if (empty($question) || empty($answer)) {
                echo "Les champs question et réponse ne peuvent pas être vides.";
                exit();
            }

            // Insertion dans la base de données
            $stmt = $conn->prepare("INSERT INTO flashcards (question, answer, user_email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $question, $answer, $email); // Utiliser l'email de l'utilisateur connecté

            if ($stmt->execute()) {
                "<script>
                    alert('Flashcard ajoutée avec succès!');
                    window.location.href='index.php';
                </script>";
            } else {
                echo "Erreur lors de l'ajout de la flashcard.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Méthode non autorisée.";
        }
    } else {
        // Si les cookies ne sont pas valides
        echo "Erreur d'authentification. Veuillez vous reconnecter.";
    }
} else {
    // Si les cookies ne sont pas définis
    echo "Vous devez être connecté pour ajouter une flashcard.";
}


?>
