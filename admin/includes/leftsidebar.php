<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Navigation</li>

                <li class="has_sub">
                    <a href="dashboard.php" class="waves-effect"><i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span> </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i> <span> Courriers </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="add-courrier.php">Enregistrer un courrier</a></li>
                        <li><a href="courrier.php">Voir les Courriers</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i> <span> Rapport </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="rapport.php">Voir le rapport</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i> <span> Rôles </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="role.php">Attribution des rôles</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>

<script>
    $(document).ready(function() {
        // Gestion des clics sur les sous-menus
        $('.has_sub > a').click(function(e) {
            e.preventDefault(); // Empêche le comportement par défaut
            $(this).next('ul').slideToggle(); // Ouvre/ferme le sous-menu
            $(this).parent().siblings().find('ul').slideUp(); // Ferme les autres sous-menus
        });
    });
</script>
