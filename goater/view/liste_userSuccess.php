<body>
    <form class="form_list"action="?action=liste_user" method="POST">
        <div class="form-group">
            <input type="text" name="search_user" class="form-control liste_search" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <?php
        if(isset($_POST["search_user"])) $liste_user = utilisateurTable::getUserByFirstNameOrLastName($_POST["search_user"]);
        else $liste_user = utilisateurTable::getUsers();
        foreach($liste_user as $user){
            $nom = $user->nom;
            $prenom = $user->prenom;
            $identifiant= $user->identifiant;
            $avatar = $user->avatar;
            if (strpos($avatar,'http') !== false) {
                $check = true;
            }
            else{
                $check = false;
            }
            if($avatar == "" || !file_exists($avatar)){
                if($check == false){
                    $avatar = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/default.png";
                }
            }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="liste_user">
                    <div class="liste_image">
                        <img src='<?php echo $avatar ?>' class="img-responsive" />
                    </div>
                    <div class="liste_info">
                        <strong><?php echo "$nom $prenom"; ?></strong><br>
                        <a href="?action=view_profile&pseudo=<?php echo $identifiant ?>" target="_blank" class="text-muted"><?php echo "@$identifiant"; ?></a>
                    </div>
                    <hr>
                </div>
            </div>
    <?php
        }
    ?>
        </div>
    </div>
</body>
</html>
