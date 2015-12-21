<body style="overflow-x:hidden;">
    <?php
        $liste_user = utilisateurTable::getUsers();
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
                    $avatar = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png";
                }
            }
    ?>
        <div class="liste_user">
            <div class="liste_image">
                <object data=<?php echo $avatar ?> type="image/png" width="150" height="150">
                    <img src='https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png' alt='photo default' width="150" height="150"/>
                </object>
            </div>
            <div class="liste_info">
                <strong><?php echo "$nom $prenom"; ?></strong><br>
                <a href="?action=view_profile&pseudo=<?php echo $identifiant ?>" target="_blank" class="text-muted"><?php echo "@$identifiant"; ?></a>
            </div>
            <hr>
        </div>

    <?php
        }
    ?>
</body>
</html>
