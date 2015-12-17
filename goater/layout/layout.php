<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/bele.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
    <?php
        echo $context->title;
        $avatar = context::getSessionAttribute("avatar");
    ?>
</title>

</head>

<body>
    <header class="row">
        <!-- ********** GOATER - MENU ********** -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="goater.php">
                    <img alt="Goater" src="images/logo-nav.png" class="goater-logo">
                </a>
                <div class="goater-header">
                    Welcome to Goater
                </div>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <?php
                    if(context::getSessionAttribute("connect") == "true"){
                        echo '<div class="dropdown pull-right">
                            <img src="'.$avatar.'" class="dropdown-toggle goater-session" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="?action=view_profile&edit=true">Modifier profil</a></li>
                                <li><a href="?action=disconnect">Deconnexion</a></li>
                            </ul>
                        </div>';
                    }
                ?>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="goater.php" id="menuhome">Accueil</a>
                    </li>
                    <li>
                        <a href="?action=liste_user" id="menuhome">Liste</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- ********** END GOATER - MENU ********** -->
    </header>
    <?php include($template_view); ?>
    <!-- ********** GOATER - JAVASCRIPT ********** -->
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- ********** END GOATER - JAVASCRIPT ********** -->
</body>

</html>
