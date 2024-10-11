<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Récupérer le rôle de l'utilisateur connecté
    $user_role = $_SESSION['role'];
    $user_id = $_SESSION['user_id'];  // Assurez-vous que l'ID de l'utilisateur est bien stocké dans la session

    // Code pour gérer le fichier PDF
    if (isset($_FILES['pdf_file']) && isset($_POST['date']) && $_FILES['pdf_file']['error'] == 0) {
        $date = mysqli_real_escape_string($con, $_POST['date']);
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $file_name = $_FILES['pdf_file']['name'];
        $file_type = $_FILES['pdf_file']['type'];

        // Vérifier si le fichier est bien un PDF
        if ($file_type == 'application/pdf') {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_path = $upload_dir . basename($file_name);

            if (move_uploaded_file($file_tmp, $file_path)) {
                // Enregistrement du chemin du fichier PDF dans la base de données
                $query = mysqli_query($con, "UPDATE courriers SET fichier_pdf='$file_path' WHERE date='$date'");
                if ($query) {
                    echo "<script>alert('Le fichier PDF a été joint avec succès.');</script>";
                } else {
                    echo "Erreur MySQL : " . mysqli_error($con);
                }
            } else {
                echo "<script>alert('Échec de l\'upload du fichier.');</script>";
            }
        } else {
            echo "<script>alert('Veuillez joindre un fichier PDF valide.');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gestion | Gérer les Courriers</title>
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
        <?php include('includes/leftsidebar.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <!-- Titre de la page -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Gérer les Courriers</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Courriers</a></li>
                                    <li class="active">Gérer les courriers</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- Bordered Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Rapports sur les courriers
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Expéditeur</th>
                                                <th>Pièce Jointe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Si l'utilisateur est un administrateur, il voit tous les courriers
                                            if ($user_role == 'admin') {
                                                $query = mysqli_query($con, "SELECT date, fichier_pdf, expediteur FROM courriers ORDER BY date DESC");
                                            } 
                                            // Si l'utilisateur est un éditeur, il voit seulement les courriers qui lui sont assignés
                                            else if ($user_role == 'editor') {
                                                $query = mysqli_query($con, "SELECT date, fichier_pdf, expediteur FROM courriers WHERE editor_id = '$user_id' ORDER BY date DESC");
                                            }

                                            while ($row = mysqli_fetch_array($query)) {
                                                $date = htmlentities($row['date']);
                                            ?>
                                            <tr>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo htmlentities($row['expediteur']); ?></td>
                                                <td>
                                                    <?php if ($row['fichier_pdf']) { ?>
                                                        <a href="<?php echo $row['fichier_pdf']; ?>" target="_blank">Voir le fichier PDF</a>
                                                    <?php } else { ?>
                                                        <!-- Seulement l'admin peut joindre un fichier PDF -->
                                                        <?php if ($user_role == 'admin') { ?>
                                                        <form method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="date" value="<?php echo $date; ?>">
                                                            <input type="file" name="pdf_file" accept="application/pdf">
                                                            <button type="submit" class="btn btn-primary">Joindre</button>
                                                        </form>
                                                        <?php } else { ?>
                                                            Aucun fichier
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <!-- Footer -->
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script>
        var resizefunc = [];
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
</body>
</html>
<?php } ?>
