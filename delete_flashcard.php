<?php
var_dump($_POST);

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

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Afficher l'ID reçu pour débogage
    echo "ID reçu pour suppression: " . $id;

    // Supprimer la flashcard de la base de données
    $stmt = $pdo->prepare("DELETE FROM flashcards WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error: ID non reçu ou vide';
}
?>
