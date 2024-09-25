<?php
session_start();
include 'db.php';  // Connexion à la base de données

$conn = new mysqli($host, $user, $password, $db);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté via les cookies
function verifyUser($conn, $email, $token) {
    $stmt = $conn->prepare("SELECT token FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($dbToken);
    $stmt->fetch();
    $stmt->close();

    return ($dbToken === $token);
}

if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    if (verifyUser($conn, $email, $token)) {
        // L'utilisateur est authentifié

        // Récupérer les flashcards existantes
        $stmt = $pdo->prepare("SELECT id, question, answer FROM flashcards WHERE user_email = ?");
        $stmt->execute([$email]);
        $flashcards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Si les cookies ne sont pas valides
        header("Location: login.php");
        exit();
    }
} else {
    // Si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcard App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="add-question-card">
            <h2>Ajouter une nouvelle flashcard</h2>
            <form>
                <label for="question">Question:</label>
                <input type="text" id="question" name="question">
                
                <label for="answer">Réponse:</label>
                <input type="text" id="answer" name="answer">

                <button id="save-btn">Sauvegarder</button>
            </form>
        </div>

    </div>

    <h1>Mes Flashcards</h1>
    <div id="flashcard-list" class="container">
        <?php foreach ($flashcards as $flashcard): ?>
    <div class="flashcard" data-id="<?php echo htmlspecialchars($flashcard['id']); ?>">
        <p>ID: <?php echo htmlspecialchars($flashcard['id']); ?></p>
        <p>Question: <?php echo htmlspecialchars($flashcard['question']); ?></p>
        <p class="answer"><?php echo htmlspecialchars($flashcard['answer']); ?></p> <!-- Réponse masquée -->
        <button class="show-answer-btn">Voir la réponse</button>
        <button class="delete-btn">Supprimer</button>
    </div>
<?php endforeach; 

foreach ($flashcards as $flashcard) {
            echo '<div class="flashcard" data-id="' . htmlspecialchars($flashcard['id']) . '">';
            echo '<p>ID: ' . htmlspecialchars($flashcard['id']) . '</p>';
            echo '<p>Question: ' . htmlspecialchars($flashcard['question']) . '</p>';
            echo '<p class="answer" style="display:none;">' . htmlspecialchars($flashcard['answer']) . '</p>';
            echo '<button class="show-answer-btn">Voir la réponse</button>';
            echo '<button class="delete-btn">Supprimer</button>';
            echo '</div>';
        }
?>


        

    <script src="save.js"></script>

</body>
</html>
