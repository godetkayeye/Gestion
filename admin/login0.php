<?php
session_start();
//Database Configuration File
include('includes/config.php');

if(isset($_POST['login']))
{
    // Récupération du nom/email et mot de passe
    $uname = $_POST['username'];
    $password = md5($_POST['password']);  // Hashage du mot de passe
    
    // Requête pour vérifier les informations de connexion
    $sql = "SELECT username, email, password FROM administration WHERE (username='$uname' OR email='$uname') AND password='$password'";
    
    // Exécuter la requête et vérifier s'il y a une erreur
    $result = mysqli_query($con, $sql);

    if(!$result) {
        // Afficher l'erreur SQL
        die("Erreur de la requête SQL : " . mysqli_error($con));
    }
    
    // Vérifier si l'utilisateur existe
    $num = mysqli_fetch_array($result);
    
    if($num > 0)
    {
        // Enregistrer la session utilisateur
        $_SESSION['login'] = $uname;
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    }
    else
    {
        // Si les détails sont invalides
        echo "<script>alert('Détails invalides. Veuillez réessayer.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta name="color-scheme" content="dark" /-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Gestion de présence et courrier.">
        <meta name="author" content="Votre Nom">

        <!-- Titre de la page -->
        <title>Connexion | Gestion de Présence et Courrier</title>

        <!-- CSS de l'application -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>
    </head>

    <body class="bg-transparent">
    Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="index.html" class="logo"><span>NP<span>Admin</span></span><i class="mdi mdi-layers"></i></a>
                    <!-- Image logo -->
                    <!--<a href="index.html" class="logo">-->
                        <!--<span>-->
                            <!--<img src="assets/images/logo.png" alt="" height="30">-->
                        <!--</span>-->
                        <!--<i>-->
                            <!--<img src="assets/images/logo_sm.png" alt="" height="28">-->
                        <!--</i>-->
                    <!--</a>-->
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <?php include('includes/topheader1.php');?>
            </div>
        <!-- SECTION DE CONNEXION -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.html" class="text-success">
                                            <span><img src="assets/images/logo.png" alt="" height="56"></span>
                                        </a>
                                    </h2>
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" method="post">

                                        <!-- Champ Nom ou Email -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" required="" name="username" placeholder="Nom ou Email" autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- Champ Mot de passe -->
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" name="password" required="" placeholder="Mot de passe" autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- Bouton de Connexion -->
                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit" name="login">Se connecter</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="clearfix"></div>
                                    <a href="register.php"><i class="mdi mdi-lock"></i> Créer un compte</a>
                                    <hr>
                                    <a href="index.php"><i class="mdi mdi-home"></i> Retour à l'accueil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SCRIPTS JAVASCRIPT -->
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
