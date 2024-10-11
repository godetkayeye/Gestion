<?php
include('includes/config.php');
require('fpdf/fpdf.php');

// Instancier FPDF
$pdf = new FPDF('P', 'mm', 'A4');  // Orientation portrait, taille A4
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Afficher la date d'exportation
$date_export = date('d-m-Y');
$pdf->Cell(0, 10, 'SUIVI DES COURRIERS', 0, 1, 'C');
$pdf->Cell(0, 10, 'Date d\'exportation: ' . $date_export, 0, 1, 'L');
$pdf->Ln(10);

// En-têtes de colonnes
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(30, 10, 'NUMERO', 1);
$pdf->Cell(30, 10, 'DATE', 1);
$pdf->Cell(40, 10, 'EXPEDITEUR', 1);
$pdf->Cell(40, 10, 'ANNEXE', 1);
$pdf->Cell(40, 10, 'RESUME', 1);
$pdf->Ln();

// Récupérer les courriers de la table courriers
$query = "SELECT id, numero, date, expediteur, annexe, resume FROM courriers WHERE date = CURDATE()";
$courriers = mysqli_query($con, $query);

// Afficher les données dans le PDF
$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($courriers)) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(30, 10, $row['numero'], 1);
    $pdf->Cell(30, 10, $row['date'], 1);
    $pdf->Cell(40, 10, $row['expediteur'], 1);
    $pdf->Cell(40, 10, $row['annexe'], 1);
    
    // Utiliser MultiCell pour le champ "Résumé" pour éviter le débordement
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 10, $row['resume'], 1);  // Utilisation de MultiCell pour gérer les longs textes
    $pdf->SetXY($x + 40, $y);  // Remettre le pointeur à la bonne position après MultiCell
    
    $pdf->Ln();
}

// Sortie du PDF
$pdf->Output('D', 'courriers_suivi.pdf');
?>
