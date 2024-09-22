<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'utilisateurs';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté via les cookies (si nécessaire)
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];

    // Préparer la requête pour récupérer les flashcards de l'utilisateur
    $stmt = $pdo->prepare("SELECT question, answer FROM flashcards WHERE user_email = ?");
    $stmt->execute([$email]);

    // Récupérer les flashcards
    $flashcards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les flashcards en JSON
    echo json_encode($flashcards);
} else {
    // Si l'utilisateur n'est pas connecté, retourner un message d'erreur
    echo json_encode(['error' => 'User not authenticated']);
}
?>
