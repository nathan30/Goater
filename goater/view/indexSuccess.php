<?php
    $nom = context::getSessionAttribute("nom");
    $prenom = context::getSessionAttribute("prenom");
    $identifiant = context::getSessionAttribute("identifiant");
    $statut = context::getSessionAttribute("statut");
    $avatar = context::getSessionAttribute("avatar");
    if (strpos($avatar,'http') !== false) $check_image = true;
        else $check_image = false;
    if($avatar == "" || file_exists($avatar) != true){
         if($check_image == false) $avatar = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png";
    }
    $id_user = context::getSessionAttribute("id");
    $nb_tweet = context::getSessionAttribute("nb_tweet");

    $user_id = utilisateurTable::getUserById($id_user);
    foreach($user_id as $user){
        $nom_emetteur = $user->nom;
        $prenom_emetteur = $user->prenom;
        $identifiant_emetteur= $user->identifiant;
        $avatar_emetteur= $user->avatar;
    }
?>
<body>
    <div class="se-pre-con">
        <p class="text-load">Patience, le site (et les images) chargent...</p>
    </div>
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
            <div class="col-sm-9">
                <form id="form-tweet" class="form_bele" action="goater.php" method="POST">
                        <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?" required></textarea>
                        <input type="hidden" name="identifiant" class="identifiant"value="<?php echo $identifiant_emetteur?>">
                        <input type="hidden" name="prenom" class="prenom" value="<?php echo "$prenom_emetteur $nom_emetteur"?>">
                        <input type="hidden" name="avatar" class="avatar" value="<?php echo $avatar_emetteur?>">
                        <input class="btn primary-btn goat-bele-submit" type="submit" value="Bêler">
                        <div class="new_tweet"></div>
                        <hr>
                    </form>
                <div class="container-goat1"></div>
                <?php
                    $goat_list = tweetTable::getTweets();
                    foreach($goat_list as $goat){
                        $id = $goat -> id;
                        $parent_info = utilisateurTable::getUserById($goat -> getParent());
                        $emetteur_info = utilisateurTable::getuserById($goat -> emetteur);
                        $post_emetteur = $goat->getPost();
                        $post_image = $post_emetteur[0] -> image;
                        if(isset($parent_info[0])){
                            $pseudo_parent = $parent_info[0] -> identifiant;
                            $prenom_parent = $parent_info[0] -> prenom;
                            $nom_parent = $parent_info[0] -> nom;
                            $avatar_parent = $parent_info[0] -> avatar;

                            if (strpos($avatar_parent,'http') !== false) $check_image = true;
                            else $check_image = false;

                            if($avatar_parent == "" || !file_exists($avatar_parent)){
                                if($check_image == false) $avatar_parent = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/default.png";
                            }
                            if (strpos($post_image,'http') !== false) $check_post_image = true;
                            else $check_post_image = false;

                            if($post_image == "" || !file_exists($post_image)){
                                if($check_post_image == false) $post_image = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/goat.png";
                            }
                            $check = true;
                        }
                        else $check = false;
                        $nbvote = $goat -> getLikes();
                        if($goat -> emetteur != $goat -> parent) $check_rt = true;
                        else $check_rt = false;

                        $check_vote = voteTable::checkVoteByIdAndUser($id,$id_user);
                    ?>
                    <div class="container-goat">
                        <blockquote class="goat-box">
                            <?php
                                if($check_rt){
                            ?>
                                <div class = "user">
                                    <p class="rt">
                                        <?php
                                            if(isset($emetteur_info[0])){
                                                $pseudo = $emetteur_info[0] -> identifiant;
                                                echo "$pseudo a retweeté ce tweet";
                                            }else echo "Utilisateur introuvable a retweeté ce tweet";
                                        ?>
                                    </p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="<?php if($check_rt) echo "if-RT"?>">
                                <?php
                                    if(!$check_rt){
                                ?>
                                        <p class="pull-right">
                                            <a href="?action=delete_tweet&id=<?php echo $id ?>&redirect=index" class="glyphicon glyphicon-trash" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce goat ?'));"></a>
                                        </p>

                                <?php
                                    }
                                ?>
                               <div class="goat-post">
                                    <p class="goat-text">
                                        <?php echo $post_emetteur[0] -> texte ?>
                                    </p>
                                    <?php
                                        if($check_post_image){
                                    ?>
                                            <img src="<?php echo "$post_image"; ?>" class="img-responsive">
                                    <?php
                                        }
                                    ?>
                                    <a href="?action=share_tweet&id=<?php echo $id?>" class="goat-time">
                                        <?php
                                            $date_post = $post_emetteur[0] -> date;
                                            $format_date = explode(" ",$date_post);
                                            $date = DateTime::createFromFormat('Y-m-d', $format_date[0]);
                                            $heure = DateTime::createFromFormat('H:i:s',$format_date[1]);
                                            echo $date -> format('l d M ');
                                            if($heure) echo $heure -> format('H:i');
                                        ?>
                                    </a>
                                </div>
                                <hr>
                                <div class = "user">
                                    <?php
                                        if($check_rt) $is_RT = "style=width:3%;";
                                        else $is_RT = "";
                                        if($check) echo "<img src='$avatar_parent' class='img-responsive' $is_RT >";
                                    ?>
                                    <p class="goat-author blog-post-bottom pull-left">

                                        <?php
                                            if($check) echo "$prenom_parent $nom_parent";
                                            else echo "Utilisateur introuvable";
                                        ?>
                                        <a href="?action=view_profile&pseudo=<?php echo $pseudo_parent?>" target="_blank">
                                            <?php
                                                if($check) echo "@$pseudo_parent";
                                            ?>
                                        </a>
                                    </p>
                                    <?php
                                        if(!$check_rt){
                                    ?>
                                            <p class="vote blog-post-bottom pull-right">
                                            <?php
                                                if($check_vote) echo "<a href='?action=deleteVote&id=$id&redirect=index' class='red like glyphicon glyphicon-heart'>";
                                                else echo "<a href='?action=addVote&id=$id&redirect=index' class='like glyphicon glyphicon-heart'>";
                                            ?>
                                                <span class="badge quote-badge"><?php echo $nbvote ?></span></a>
                                            <?php
                                                if($goat -> emetteur != $id_user){
                                            ?>
                                                <a href="?action=rtTweet&id=<?php echo $id?>" class="retweet glyphicon glyphicon-retweet" onclick="return(confirm('Etes-vous sûr de vouloir retweeter ce goat ?'));"></a>
                                                <?php
                                                    }
                                                ?>
                                            </p>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>
