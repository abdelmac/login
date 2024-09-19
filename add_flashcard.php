<?php
session_start();
include 'db.php'; // Inclusion de la connexion à la base de données

header('Content-Type: application/json');  // S'assure que la réponse est en JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification que l'utilisateur est connecté
    if (isset($_SESSION['username'])) {
        $question = trim($_POST['question']);
        $answer = trim($_POST['answer']);

        // Validation des champs
        if (empty($question) || empty($answer)) {
            echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
            exit();
        }

        // Requête d'insertion avec une requête préparée pour éviter les injections SQL
        $stmt = $conn->prepare("INSERT INTO flashcards (question, answer, user) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question, $answer, $_SESSION['username']);

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
