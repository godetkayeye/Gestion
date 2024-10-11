<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Récupérer l'ID de l'éditeur connecté à partir de la session
    $editor_id = $_SESSION['user_id'];

    // Recherche par expéditeur
    $search_exp = "";
    if (isset($_POST['search_exp'])) {
        $search_exp = mysqli_real_escape_string($con, $_POST['search_exp']);
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
        <?php include('includes/topheader.php');?>
        <?php include('includes/leftsidebar0.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Gérer les Courriers</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Courriers</a></li>
                                    <li class="active">Gérer les Courriers</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="export-buttons">
                        <a href="add-courrier1.php" class="btn btn-success">Ajouter un courrier<i class="mdi mdi-plus-circle-outline"></i></a>
                    </div>

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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">
                                <div class="table-responsive">
                                    <table class="table m-0 table-colored-bordered table-bordered-primary">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DATE</th>
                                                <th>NUMERO</th>
                                                <th>ANNEXES</th>
                                                <th>EXPEDITEURS</th>
                                                <th>RESUMES</th>
                                                <th>OBSERVATIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Requête pour récupérer les courriers assignés à cet éditeur via la table editor_permissions
                                            $query = "
                                                SELECT c.* 
                                                FROM courriers c
                                                INNER JOIN editor_permissions ep ON c.id = ep.courrier_id
                                                WHERE ep.editor_id = '$editor_id'";

                                            if ($search_exp != "") {
                                                $query .= " AND c.expediteur = '$search_exp'";
                                            }

                                            $query .= " ORDER BY c.date DESC";
                                            
                                            $result = mysqli_query($con, $query);

                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $annexe_link = !empty($row['fichier_pdf']) ? "<a href='uploads/{$row['fichier_pdf']}' target='_blank'>Voir le PDF</a>" : "Aucun fichier";
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                            <td><?php echo htmlentities($row['date']); ?></td>
                                                            <td><?php echo htmlentities($row['numero']); ?></td>
                                                            <td><?php echo $annexe_link; ?></td>
                                                            <td><?php echo htmlentities($row['expediteur']); ?></td>
                                                            <td><?php echo htmlentities($row['resume']); ?></td>
                                                            <td><?php echo htmlentities($row['observation']); ?></td>
                                                        </tr>
                                            <?php
                                                        $cnt++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>Aucun courrier trouvé.</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>Erreur lors de la récupération des courriers.</td></tr>";
                                            }
                                            ?>
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
