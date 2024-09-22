<?php
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

if (isset($_POST['id']) && isset($_POST['question']) && isset($_POST['answer'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Mettre à jour la flashcard dans la base de données
    $stmt = $pdo->prepare("UPDATE flashcards SET question = ?, answer = ? WHERE id = ?");
    if ($stmt->execute([$question, $answer, $id])) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
