<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php'; // Inclusion de la connexion à la base de données

header('Content-Type: application/json');  // S'assure que la réponse est en JSON

// Vérification de l'authentification via les cookies
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    // Utilisation de requêtes préparées pour sécuriser les données
    $req = $bdd->prepare("SELECT pseudo FROM users WHERE email = :email AND token = :token");
    $req->execute(['email' => $email, 'token' => $token]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);

    // Vérification de l'existence de l'utilisateur
    if ($rep && !empty($rep['pseudo'])) {
        // Stocker l'utilisateur dans la session
        $_SESSION['user'] = $rep['pseudo'];
    } else {
        // Si l'authentification échoue, retour d'une réponse JSON d'erreur
        echo json_encode(['status' => 'error', 'message' => 'Authentification échouée. Veuillez vous reconnecter.']);
        exit();
    }
} else {
    // Si les cookies ne sont pas définis, retour d'une réponse JSON d'erreur
    echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour ajouter une flashcard.']);
    exit();
}

// Traitement de l'ajout de la flashcard
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification que l'utilisateur est connecté via la session
    if (isset($_SESSION['user'])) {
        $question = trim($_POST['question']);
        $answer = trim($_POST['answer']);

        // Validation des champs
        if (empty($question) || empty($answer)) {
            echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
            exit();
        }

        // Requête d'insertion avec une requête préparée pour éviter les injections SQL
        $stmt = $bdd->prepare("INSERT INTO flashcards (question, answer, user) VALUES (:question, :answer, :user)");
        $result = $stmt->execute([
            'question' => $question,
            'answer' => $answer,
            'user' => $_SESSION['user']
        ]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Carte ajoutée avec succès.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la carte.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour ajouter une flashcard.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
}

?>
