<?php
session_start();
include('includes/config.php');

// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Code pour ajouter un nouveau courrier
    if (isset($_POST['submit'])) {
        $numero = mysqli_real_escape_string($con, $_POST['numero']);
        $date = mysqli_real_escape_string($con, $_POST['date']);
        $expediteur = mysqli_real_escape_string($con, $_POST['expediteur']);
        $annexe = mysqli_real_escape_string($con, $_POST['annexe']);
        $resume = mysqli_real_escape_string($con, $_POST['resume']);
        $observation = mysqli_real_escape_string($con, $_POST['observation']);
        $editor_id = mysqli_real_escape_string($con, $_POST['editor_id']);  // Récupérer l'éditeur assigné
        $file_path = '';

        // Gestion du fichier PDF scanné
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == 0) {
            $file_tmp = $_FILES['fichier']['tmp_name'];
            $file_name = $_FILES['fichier']['name'];
            $file_size = $_FILES['fichier']['size'];
            $file_type = $_FILES['fichier']['type'];

            // Vérifier si le fichier est bien un PDF
            if ($file_type == 'application/pdf') {
                // Déplacer le fichier vers un dossier sur le serveur
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_path = $upload_dir . basename($file_name);

                if (!move_uploaded_file($file_tmp, $file_path)) {
                    echo "<script>alert('Échec de l\'upload du fichier.');</script>";
                    $file_path = '';
                }
            } else {
                echo "<script>alert('Veuillez joindre un fichier PDF valide.');</script>";
            }
        }

        // Vérification que les champs ne sont pas vides (sauf 'annexe' et 'observation')
        if (!empty($numero) && !empty($date) && !empty($expediteur) && !empty($resume)) {
            // Insertion des données dans la table 'courriers'
            $query = mysqli_query($con, "INSERT INTO courriers (numero, date, expediteur, annexe, resume, observation, fichier_pdf) 
                                         VALUES ('$numero', '$date', '$expediteur', '$annexe', '$resume', '$observation', '$file_path')");

            // Vérification si la requête a réussi
            if ($query) {
                echo "<script>alert('Le courrier a été ajouté avec succès.');</script>";
                echo "<script type='text/javascript'> document.location = 'editorcourrier.php'; </script>";
            } else {
                echo "Erreur MySQL : " . mysqli_error($con);
            }
        } else {
            echo "<script>alert('Veuillez remplir tous les champs obligatoires.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gestion | Ajouter un courrier</title>

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/modernizr.min.js"></script>
</head>

<body class="fixed-left">
    <div id="wrapper">
        <!-- Inclure le Top Header -->
        <?php include('includes/topheader.php');?>

        <!-- Inclure la barre latérale -->
        <?php include('includes/leftsidebar0.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Ajouter un courrier</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Courriers</a></li>
                                    <li class="active">Ajouter Courrier</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire pour ajouter un courrier -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title"><b>Ajouter Courrier</b></h4>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="addcourrier" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="numero">Numéro de Courrier</label>
                                                <input type="text" name="numero" id="numero" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Date d'Arrivée</label>
                                                <input type="date" name="date" id="date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="expediteur">Expéditeur</label>
                                                <select name="expediteur" id="expediteur" class="form-control" required>
                                                    <option value="">Sélectionner un expéditeur</option>
                                                    <option value="S.G.A.C/INBTP"> S.G.A.C/INBTP </option>
                                                    <option value="S.G.A.D/INBTP"> S.G.A.D/INBTP </option>
                                                    <option value="S.G.R/INBTP"> S.G.R/INBTP </option>
                                                    <option value="D.G/INBTP"> D.G/INBTP </option>
                                                    <option value="CENTRE MEDICAL/INBTP"> CENTRE MEDICAL/INBTP </option>
                                                    <option value="AUMONERIE UNIVERSITAIRE"> AUMONERIE UNIVERSITAIRE </option>
                                                    <option value="PROTESTANTE PROVINCE DE KINSHASA"> PROTESTANTE PROVINCE DE KINSHASA </option>
                                                    <option value="PAROISE DE L'INBTP"> PAROISE DE L'INBTP </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="annexe">Annexe</label>
                                                <input type="text" name="annexe" id="annexe" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="resume">Résumé</label>
                                                <textarea name="resume" id="resume" class="form-control" rows="5" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="observation">Observation</label>
                                                <textarea name="observation" id="observation" class="form-control" rows="3"></textarea>
                                            </div>

                                            <!-- Ajout du formulaire pour joindre un fichier PDF -->
                                            <div class="form-group">
                                                <label for="fichier">Joindre un fichier scanné (PDF uniquement)</label>
                                                <input type="file" name="fichier" id="fichier" class="form-control" accept="application/pdf">
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <!-- Inclure le Footer -->
        <?php include('includes/footer.php'); ?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
