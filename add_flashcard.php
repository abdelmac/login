<?php
session_start();

include 'db.php'; // Inclusion de la connexion à la base de données

header('Content-Type: application/json');  // S'assure que la réponse est en JSON


if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    // Utilisation de requêtes préparées pour sécuriser les données
    $req = $bdd->prepare("SELECT pseudo FROM users WHERE email = :email AND token = :token");
    $req->execute(['email' => $email, 'token' => $token]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);

    // Vérification de l'existence de l'utilisateur
    if ($rep && !empty($rep['pseudo'])) {
        echo "Vous êtes connecté, " . htmlspecialchars($rep['pseudo']) . " !";
    } else {
        // Rediriger vers la page de connexion en cas d'échec
        header("Location: login.php");
        exit();
    }
} else {
    // Si les cookies ne sont pas définis, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour ajouter une flashcard.']);
    exit();
} else {
    echo json_encode(['status' => 'success', 'message' => 'Utilisateur connecté: ' . $_SESSION['user']]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification que l'utilisateur est connecté
    if (isset($_SESSION['user'])) {
        $question = trim($_POST['question']);
        $answer = trim($_POST['answer']);

        // Validation des champs
        if (empty($question) || empty($answer)) {
            echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
            exit();
        }

        // Requête d'insertion avec une requête préparée pour éviter les injections SQL
        $stmt = $conn->prepare("INSERT INTO flashcards (question, answer, user) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question, $answer, $_SESSION['user']);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Carte ajoutée avec succès.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la carte.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour ajouter une flashcard.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
}

?>