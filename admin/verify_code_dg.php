<?php
// Code de sécurité défini pour le D.G
$dg_code = "67890";  // Vous pouvez modifier ce code

// Récupérer le code envoyé via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $received_code = isset($_POST['code']) ? $_POST['code'] : '';

    // Vérifier si le code correspond
    if ($received_code === $dg_code) {
        // Si le code est correct, envoyer un message de succès
        echo json_encode(['success' => true]);
    } else {
        // Si le code est incorrect, renvoyer une erreur
        echo json_encode(['success' => false]);
    }
}
?>
