<?php
// Code de sécurité défini (vous pouvez le changer)
$correct_code = "2@24";

// Récupérer le code envoyé via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $received_code = isset($_POST['code']) ? $_POST['code'] : '';

    // Vérifier si le code correspond
    if ($received_code === $correct_code) {
        // Si le code est correct, envoyer un message de succès
        echo json_encode(['success' => true]);
    } else {
        // Si le code est incorrect, renvoyer une erreur
        echo json_encode(['success' => false]);
    }
}
?>
