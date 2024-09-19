<?php
include 'db.php';
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM flashcards WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $flashcards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Si aucune flashcard n'est trouvée, renvoie un message explicite
    if (empty($flashcards)) {
        echo json_encode(['status' => 'error', 'message' => 'No flashcards found']);
    } else {
        echo json_encode(['status' => 'success', 'flashcards' => $flashcards]);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
