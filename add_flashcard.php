<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Connexion à la base de données (remplacez les valeurs par les vôtres)
$host = "localhost";
$db = "utilisateurs";  // Changez par le nom de votre base de données
$user = "root";  // Changez par votre nom d'utilisateur
$password = "root";  // Changez par votre mot de passe

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion à la base de données.']);
    exit();
}

// Vérifier si l'utilisateur est connecté via les cookies
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    // Vérifier l'utilisateur dans la base de données (ajustez selon votre structure)
    $stmt = $bdd->prepare("SELECT id FROM utilisateurs WHERE email = ? AND token = ?");
    $stmt->execute([$email, $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // L'utilisateur est authentifié
        $user_id = $user['id'];

        // Récupérer la question et la réponse envoyées en POST
        $question = isset($_POST['question']) ? trim($_POST['question']) : null;
        $answer = isset($_POST['answer']) ? trim($_POST['answer']) : null;

        // Vérifier que les champs ne sont pas vides
        if (empty($question) || empty($answer)) {
            echo json_encode(['status' => 'error', 'message' => 'Les champs question et réponse ne peuvent pas être vides.']);
            exit();
        }

        // Insérer la flashcard dans la base de données
        $stmt = $bdd->prepare("INSERT INTO flashcards (user_id, question, answer) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $question, $answer])) {
            echo json_encode(['status' => 'success', 'message' => 'Flashcard ajoutée avec succès.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la flashcard.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Utilisateur non authentifié.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cookies non définis.']);
}

?>