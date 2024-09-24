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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcards</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Vos Flashcards</h1>
        <div id="flashcard-list">
            <?php foreach ($flashcards as $flashcard): ?>
    <div class="card" data-id="<?php echo htmlspecialchars($flashcard['id']); ?>">
        <p>Question: <?php echo htmlspecialchars($flashcard['question']); ?></p>
        <p>Réponse: <?php echo htmlspecialchars($flashcard['answer']); ?></p>
        <button class="delete-btn">Supprimer</button>
    </div>
<?php endforeach; ?>

        </div>

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

    <script src="save.js"></script>

</body>
</html>
