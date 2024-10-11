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

    // Code pour gérer l'enregistrement d'un nouvel utilisateur
    if (isset($_POST['register_user'])) {
        $username = $_POST['new_username'];
        $email = $_POST['new_email'];
        $password = md5($_POST['new_password']);
        $role = $_POST['new_role'];

        // Vérification de l'existence de l'utilisateur
        $check_query = "SELECT * FROM utilisateur WHERE username = ? OR email = ?";
        $stmt_check = $con->prepare($check_query);
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<script>alert('Cet utilisateur existe déjà');</script>";
        } else {
            // Insérer le nouvel utilisateur dans la base de données
            $insert_query = "INSERT INTO utilisateur (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt_insert = $con->prepare($insert_query);
            $stmt_insert->bind_param("ssss", $username, $email, $password, $role);
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                echo "<script>alert('Utilisateur enregistré avec succès');</script>";
            } else {
                echo "<script>alert('Erreur lors de l\'enregistrement de l\'utilisateur');</script>";
            }
        }
    }

    // Gestion de l'attribution des permissions
    if (isset($_POST['assign_permissions'])) {
        $editor_id = $_POST['editor_id'];
        $courrier_ids = $_POST['courrier_ids'];

        // Préparation de la requête d'insertion
        $insert_query = "INSERT INTO editor_permissions (editor_id, courrier_id) VALUES (?, ?)";
        $stmt_insert = $con->prepare($insert_query);

        foreach ($courrier_ids as $courrier_id) {
            // Vérifier si la permission existe déjà pour cet éditeur et ce courrier
            $check_query = "SELECT * FROM editor_permissions WHERE editor_id = ? AND courrier_id = ?";
            $stmt_check = $con->prepare($check_query);
            $stmt_check->bind_param("ii", $editor_id, $courrier_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows == 0) {
                // Si la permission n'existe pas encore, on l'ajoute
                $stmt_insert->bind_param("ii", $editor_id, $courrier_id);
                $stmt_insert->execute();
            }
        }

        echo "<script>alert('Permissions attribuées avec succès');</script>";
    }

    // Récupérer tous les utilisateurs
    $query = "SELECT id, username, role FROM utilisateur";
    $result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gestion | Attribuer un rôle et Enregistrer un Utilisateur</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/modernizr.min.js"></script>
    <style>
        /* Ajoutez des styles CSS personnalisés si nécessaire */
        @media (max-width: 768px) {
            .table {
                width: 100%;
                overflow-x: auto;
                display: block;
            }
            .table-responsive {
                overflow: hidden;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>

<body class="fixed-left">
    <div id="wrapper">
        <?php include('includes/topheader.php');?>
        <?php include('includes/leftsidebar.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Attribuer un rôle et Enregistrer un Utilisateur</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Rôles</a></li>
                                    <li class="active">Attribuer un rôle et Enregistrer un Utilisateur</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Gestion des rôles utilisateurs -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Utilisateurs</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom d'utilisateur</th>
                                        <th>Rôle actuel</th>
                                        <th>Attribuer un rôle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['role']; ?></td>
                                        <td>
                                            <form method="post" action="">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <select name="role" class="form-control">
                                                    <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
                                                    <option value="editor" <?php if ($row['role'] == 'editor') echo 'selected'; ?>>Éditeur</option>
                                                    <option value="viewer" <?php if ($row['role'] == 'viewer') echo 'selected'; ?>>Visualisateur</option>
                                                </select>
                                                <button type="submit" name="assign_role" class="btn btn-primary mt-2">Attribuer</button>
                                            </form>

                                            <?php if ($row['role'] == 'editor') { 
                                                // Récupérer les courriers ici pour chaque éditeur
                                                $courrier_query = "SELECT id, expediteur FROM courriers";
                                                $courrier_result = mysqli_query($con, $courrier_query);
                                            ?>
                                            <form method="post" action="">
                                                <input type="hidden" name="editor_id" value="<?php echo $row['id']; ?>">
                                                <select name="courrier_ids[]" multiple class="form-control" required>
                                                    <?php while ($courrier = mysqli_fetch_assoc($courrier_result)) { ?>
                                                        <option value="<?php echo $courrier['id']; ?>"><?php echo $courrier['expediteur']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <button type="submit" name="assign_permissions" class="btn btn-secondary mt-2">Attribuer Permissions</button>
                                            </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Formulaire d'enregistrement d'un nouvel utilisateur -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Enregistrer un nouvel utilisateur</h4>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Nom d'utilisateur</label>
                                    <input type="text" name="new_username" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="new_email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Rôle</label>
                                    <select name="new_role" class="form-control">
                                        <option value="admin">Administrateur</option>
                                        <option value="editor">Éditeur</option>
                                        <option value="viewer">Visualisateur</option>
                                    </select>
                                </div>
                                <button type="submit" name="register_user" class="btn btn-success">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
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
<?php } ?>
