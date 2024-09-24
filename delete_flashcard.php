<?php
$host = 'localhost';
$db = 'utilisateurs';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Could not connect to the database: ' . $e->getMessage()]));
}

// Vérifiez si l'ID est reçu
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Préparer la requête SQL pour supprimer la flashcard
    $stmt = $pdo->prepare("DELETE FROM `flashcards` WHERE `id` = ?");
    
    // Exécuter la requête avec l'ID
    if ($stmt->execute([$id])) {
        echo json_encode(['status' => 'success', 'message' => 'Flashcard supprimée avec succès.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression de la flashcard.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID non reçu ou vide.']);
}
?>
