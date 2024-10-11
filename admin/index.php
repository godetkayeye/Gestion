<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion de présence et courrier.">
    <meta name="author" content="Votre Nom">
    <title>Connexion | Gestion des Courriers</title>

    <!-- CSS de l'application -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/modernizr.min.js"></script>

    <style>
        body {
            background-image: url('assets/images/img.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
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
                                    <span><img src="assets/images/logo1.png" alt="" height="56"></span>
                                </a>
                            </h2>
                        </div>
                        <div class="account-content">
                            <p class="text-center">
                                Bienvenue dans le système de gestion des courriers de l'INBTP. Connectez-vous pour accéder à vos courriers et gérer vos tâches selon votre rôle.
                            </p>
                            <form class="form-horizontal" method="post">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" required="" name="username" placeholder="Email"
                                               value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="password" name="password" required="" placeholder="Mot de passe" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="checkbox checkbox-primary">
                                            <input id="remember" type="checkbox" name="remember" <?php if(isset($_COOKIE['username'])) { echo 'checked'; } ?>>
                                            <label for="remember">Se souvenir de moi</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group account-btn text-center m-t-10">
                                    <div class="col-xs-12">
                                        <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit" name="login">Se connecter</button>
                                    </div>
                                </div>
                            </form>
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
