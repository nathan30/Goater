<?php
    if(context::getSessionAttribute("connect") != "true"){
        header('Location:?action=login');
    }
    else{
        $nom = context::getSessionAttribute("nom");
        $prenom = context::getSessionAttribute("prenom");
        $identifiant = context::getSessionAttribute("identifiant");
        $statut = context::getSessionAttribute("statut");
        $avatar = context::getSessionAttribute("avatar");
        if($avatar == "" || file_exists($avatar) != true){
            $avatar = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png";
        }
        $id_user = context::getSessionAttribute("id");
        $nb_tweet = context::getSessionAttribute("nb_tweet");

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 goater-user-left">
                <a class="image-cover" style="background-image: url(<?php echo $avatar?>);">

                </a>
                <div class="goater-pseudo">
                    <p class="nom">
                        <?php echo"$nom $prenom";?>
                    </p>
                    <p class="pseudo">
                        <a href="?action=view_profile&pseudo=<?php echo $identifiant ?>" target="_blank"><?php echo "@$identifiant" ?></a>
                    </p>
                </div>
                <div class="goater-infos">
                    <ul class="goater-stats">
                        <li>
                            <span class="stats-label block">Bêles</span>
                            <span class="stats-val"><?php echo $nb_tweet ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <form action="#" method="POST">
                    <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?"></textarea>
                    <input class="btn primary-btn goat-bele-submit" type="submit" value="Bêler">
                    <?php
                        if(isset($_POST["tweet"])){
                            tweetTable::sendTweet($_POST["tweet"]);
                        }
                    ?>
                </form>
                <?php
                    $goat_list = tweetTable::getTweets();
                    foreach($goat_list as $goat){
                        $parent_info = utilisateurTable::getUserById($goat -> getParent());
                        $post_emetteur = $goat->getPost();
                        if(isset($parent_info[0])){
                            $pseudo_parent = $parent_info[0] -> identifiant;
                            $prenom_parent = $parent_info[0] -> prenom;
                            $nom_parent = $parent_info[0] -> nom;
                            $avatar_parent = $parent_info[0] -> avatar;
                            if (strpos($avatar_parent,'http') !== false) {
                                $check = true;
                            }
                            else{
                                $check = false;
                            }
                            if($avatar_parent == "" || !file_exists($avatar_parent)){
                                if($check == false){
                                    $avatar_parent = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png";
                                }
                            }
                            $check = true;
                        }
                        else $check = false;
                        $nbvote = $goat -> getLikes();
                    ?>
                    <blockquote class="goat-box">
                        <p class="goat-text">
                            <?php
                                echo $post_emetteur[0] -> texte;
                            ?>
                        </p>
                        <hr>
                        <div class = "user">
                            <?php
                                if($check){
                                    echo "<img src='$avatar_parent' class='img-responsive'>";
                                }
                            ?>
                            <p class="goat-author blog-post-bottom pull-left">

                                <?php
                                    if($check){
                                        echo "$prenom_parent $nom_parent ";
                                    }
                                    else{
                                        echo "Utilisateur introuvable";
                                    }

                                ?>
                                <a href="?action=view_profile&pseudo=<?php echo $pseudo_parent?>" target="_blank">
                                    <?php
                                        if($check) echo "@$pseudo_parent";
                                    ?>
                                </a>
                            </p>
                            <p class="blog-post-bottom pull-right">
                                <span class="badge quote-badge"><?php echo $nbvote ?></span>
                                <a class="like glyphicon glyphicon-heart"></a>
                            </p>
                        </div>
                    </blockquote>
                <?php
                    }
                ?>
            </div>
            <div class="col-sm-3 user-list-index">
                <h3>Liste des utilisateurs</h3>
                <?php
                    include 'goater/view/liste_userSuccess.php';
                ?>
            </div>
        </div>
    </div>
</body>
<?php
    }
?>
