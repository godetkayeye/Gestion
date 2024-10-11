<?php
session_start();
include('includes/config.php');

if (isset($_POST['date'])) {
    $date = mysqli_real_escape_string($con, $_POST['date']);
    
    // Dossier d'upload
    $output_dir = 'uploads/';
    if (!is_dir($output_dir)) {
        mkdir($output_dir, 0777, true);
    }

    // Chemin du fichier scanné
    $file_path = $output_dir . 'scanned_' . time() . '.pdf';

    // Appel à un fichier batch pour lancer la numérisation avec un outil comme NAPS2
    $command = 'scan.bat';  // Assurez-vous que "scan.bat" est dans le même répertoire ou spécifiez son chemin
    exec($command, $output, $return_var);

    if ($return_var == 0) {
        // Enregistrer le chemin du fichier PDF scanné dans la base de données
        $query = "UPDATE courriers SET fichier_pdf='$file_path' WHERE date='$date'";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Le document scanné a été joint avec succès.'); window.location.href = 'courriers.php';</script>";
        } else {
            echo "Erreur MySQL : " . mysqli_error($con);
        }
    } else {
        echo "<script>alert('Échec de la numérisation du document.'); window.location.href = 'courriers.php';</script>";
    }
}
?>
