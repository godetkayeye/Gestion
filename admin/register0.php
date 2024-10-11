<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Vérifier si l'administrateur existe déjà
    $query = mysqli_query($con, "SELECT id FROM utilisateur WHERE email='$email'");
    $ret = mysqli_num_rows($query);

    if($ret > 0){
        echo "<script>alert('L'adresse email existe déjà. S`\il vous plais réessayer avec un nouvelle adresse mail');</script>";
    } else {
        // Insérer un nouvel administrateur
        $query1 = mysqli_query($con, "INSERT INTO utilisateur(username, email, password) VALUES('$username', '$email', '$password')");
        if($query1){
            echo "<script>alert('Autorité enregistré avec succès. Merci !');</script>";
            echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
        } else {
            echo "<script>alert('Erreur, Veuillez Patienter et Réssayez apres 3sec.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Administration Portal">
        <meta name="author" content="Your Name">
        <title>Admin Registration</title>

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>

        <script type="text/javascript">
            function validatePassword() {
                if (document.register.password.value != document.register.confirmpassword.value) {
                    alert('Password and Confirm Password do not match.');
                    document.register.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>

    <body class="bg-transparent">
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper-page">
                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.php" class="text-success">
                                            <span><img src="assets/images/logo1.png" alt="" height="56"></span>
                                        </a>
                                    </h2>
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" method="post" name="register" onsubmit="return validatePassword();">

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" name="username" required="" placeholder="Votre nom" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="email" name="email" required="" placeholder="Votre Email" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" name="password" required="" placeholder="Votre mot de passe">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" name="confirmpassword" required="" placeholder="Comfirmer votre mot de passe">
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-success waves-effect waves-light" type="submit" name="submit">Enregistrer</button>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="clearfix"></div>
                                    <a href="login.php"><i class="mdi mdi-home"></i> Conectez-vous</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
