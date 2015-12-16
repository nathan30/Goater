<?php
    if(context::getSessionAttribute("connect") != "true"){
        header('Location:?action=login');
    }
    else{

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 goater-user-left">
                <a class="image-cover">

                </a>
                <div class="goater-pseudo">
                    <p class="nom">
                        Nathan
                    </p>
                    <p class="pseudo">
                        @chwal84
                    </p>
                </div>
                <div class="goater-infos">
                    <ul class="goater-stats">
                        <li>
                            <span class="stats-label block">Bêles</span>
                            <span class="stats-val">1000</span>
                        </li>
                        <li>
                            <span class="stats-label block moutons">Moutons</span>
                            <span class="stats-val moutons">1000</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <form action="#" method="POST">
                    <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?"></textarea>
                    <input class="btn primary-btn goat-bele-submit" type="submit" value="Bêler">
                </form>
            </div>
            <div class="col-sm-3 user-list-index">
                <h3>Liste des utilisateurs</h3>
                <?php
                    include 'goater/view/liste_userSuccess.php';
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                    include 'goater/view/beleSuccess.php';
                    include 'goater/view/beleSuccess.php';
                    include 'goater/view/beleSuccess.php';
                ?>
            </div>
        </div>
    </div>
</body>
<?php
    }
?>
