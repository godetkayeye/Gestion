<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Recherche par expéditeur
    $search_exp = "";
    if (isset($_POST['search_exp'])) {
        $search_exp = mysqli_real_escape_string($con, $_POST['search_exp']);
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gestion | Les Courriers</title>
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
                                    <h4 class="page-title">Voir les Courriers</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Courriers</a></li>
                                        <li class="active">Voir les Courriers</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                       

                        <!-- Formulaire de recherche par expéditeur -->
                        <div class="search-section m-t-20">
                            <form method="post" action="courrier.php">
                                <div class="form-group">
                                    <label for="search_exp">Rechercher par expéditeur:</label>
                                    <select name="search_exp" id="search_exp" class="form-control">
                                        <option value="">Sélectionner un expéditeur</option>
                                        <option value="S.G.A.C/INBTP" <?php echo ($search_exp == 'S.G.A.C/INBTP') ? 'selected' : ''; ?>>S.G.A.C/INBTP</option>
                                        <option value="S.G.A.D/INBTP" <?php echo ($search_exp == 'S.G.A.D/INBTP') ? 'selected' : ''; ?>>S.G.A.D/INBTP</option>
                                        <option value="S.G.R/INBTP" <?php echo ($search_exp == 'S.G.R/INBTP') ? 'selected' : ''; ?>>S.G.R/INBTP</option>
                                        <option value="D.G/INBTP" <?php echo ($search_exp == 'D.G/INBTP') ? 'selected' : ''; ?>>D.G/INBTP</option>
                                        <option value="CENTRE MEDICAL/INBTP" <?php echo ($search_exp == 'CENTRE MEDICAL/INBTP') ? 'selected' : ''; ?>>CENTRE MEDICAL/INBTP</option>
                                        <option value="AUMONERIE UNIVERSITAIRE" <?php echo ($search_exp == 'AUMONERIE UNIVERSITAIRE') ? 'selected' : ''; ?>>AUMONERIE UNIVERSITAIRE</option>
                                        <option value="PROSTESTANTE PROVINCE DE KINSHASA" <?php echo ($search_exp == 'PROSTESTANTE PROVINCE DE KINSHASA') ? 'selected' : ''; ?>>PROSTESTANTE PROVINCE DE KINSHASA</option>
                                        <option value="PAROISE DE L'INBTP" <?php echo ($search_exp == 'PAROISE DE L\'INBTP') ? 'selected' : ''; ?>>PAROISE DE L'INBTP</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">Rechercher</button>
                            </form>
                        </div>

                        <!-- Liste des courriers -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>DATE</th>
                                                    <th>NUMERO </th>
                                                    <th>ANNEXES</th>
                                                    <th>EXPEDITEURS</th>
                                                    <th>RESUMES</th>
                                                    <th>OBSERVATIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Recherche des courriers par expéditeur
                                                if ($search_exp != "") {
                                                    $query = mysqli_query($con, "SELECT * FROM courriers WHERE expediteur='$search_exp' ORDER BY date DESC");
                                                } else {
                                                    $query = mysqli_query($con, "SELECT * FROM courriers ORDER BY date DESC");
                                                }

                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    // Vérifier si un fichier PDF est attaché
                                                    $annexe_link = !empty($row['fichier_pdf']) ? "<a href='uploads/{$row['fichier_pdf']}' target='_blank'>Voir le PDF</a>" : "Aucun fichier";
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['date']); ?></td>
                                                    <td><?php echo htmlentities($row['numero']); ?></td>
                                                    <td><?php echo $annexe_link; ?></td> <!-- Lien vers le PDF -->
                                                    <td><?php echo htmlentities($row['expediteur']); ?></td>
                                                    <td><?php echo htmlentities($row['resume']); ?></td>
                                                    <td><?php echo htmlentities($row['observation']); ?></td>
                                                <?php
                                                $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
