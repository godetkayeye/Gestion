<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gestion | Archives des courriers</title>
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
            <?php include('includes/topheader1.php');?>

            <!-- Inclure la barre latérale -->
            <?php include('includes/leftsidebar1.php');?>

            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <!-- Titre de la page -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Archives des courriers</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Courriers</a></li>
                                        <li class="active">Archives des courriers</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Table des archives des courriers -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     Archives des courriers
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
                                                // Récupérer les courriers groupés par date
                                                $query = mysqli_query($con, "SELECT date, fichier_pdf, expediteur FROM courriers ORDER BY date DESC");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $date = htmlentities($row['date']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo htmlentities($row['expediteur']); ?></td>
                                                    <td>
                                                        <?php if (!empty($row['fichier_pdf'])) { ?>
                                                            <a href="<?php echo $row['fichier_pdf']; ?>" target="_blank">Voir le fichier PDF</a>
                                                        <?php } else { ?>
                                                            <span style="color:red;">Aucun fichier joint pour cette date</span>
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
