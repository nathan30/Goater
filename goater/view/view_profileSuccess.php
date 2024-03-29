<?php
// <!-- ********** GOATER - RETRIEVE DATA ********** -->
    if(isset($_REQUEST["pseudo"])){
        $nom = $context->nom;
        $prenom = $context->prenom;
        $identifiant = $context->identifiant;
        $statut = $context->statut;
        $avatar = $context->avatar;
        $id_user = $context->id_user;
        $nb_tweet = $context -> nb_tweet;
    }
    else{
        $nom = context::getSessionAttribute("nom");
        $prenom = context::getSessionAttribute("prenom");
        $identifiant = context::getSessionAttribute("identifiant");
        $statut = context::getSessionAttribute("statut");
        $avatar = context::getSessionAttribute("avatar");
        $id_user = context::getSessionAttribute("id");
        $nb_tweet = context::getSessionAttribute("nb_tweet");
    }
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
    $user_id = utilisateurTable::getUserById($id_user);
    foreach($user_id as $user){
        $nom_emetteur = $user->nom;
        $prenom_emetteur = $user->prenom;
        $identifiant_emetteur= $user->identifiant;
        $avatar_emetteur= $user->avatar;
    }
    $tweet = tweetTable::getTweets();

 // <!-- ********** END GOATER - RETRIEVE DATA ********** -->
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <?php
                if(isset($_REQUEST["edit"]) && $_REQUEST["edit"] == "true" && !isset($_REQUEST["pseudo"])){
                    $size = "col-md-6";
            ?>
                    <form id='form-update' action='?action=view_profile&edit=true' method='POST' enctype="multipart/form-data" style="position: relative; top: 10px;">
                        <div class="form-group">
                            <input type="text" placeholder="Prenom" name="prenom_update" id="prenom" required="required" value="<?php echo $prenom ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Nom" name="nom_update" id="nom" required="required" value="<?php echo $nom ?>">
                        </div>
                        <div class="form-group">
                            <input type="file" name="avatar" id="avatar">
                        </div>
                        <div class="form-group">
                            <textarea id="statut" name='statut_update' rows='4' class='form-control' maxlength='100' style='resize:none'><?php echo $statut ?></textarea>
                        </div>
                        <div class="form-group">
                            <input type='submit' value="Mettre à jour le profil">
                        </div>
                    </form>
            <?php
                }
                else{
                    $size = "col-md-offset-2 col-md-8";
               }
            ?>
            </div>
            <div class="bigger <?php echo $size ?>">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <h2 id="nom_prenom">
                                <?php
                                    echo "$nom $prenom";
                                ?>
                            </h2>
                            <p><strong>Pseudo: </strong>
                                <?php echo "@$identifiant"?>
                            </p>
                            <p><strong>Statut: </strong>
                                <span id="statut_form"><?php echo $statut;?></span>
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <img src='<?php echo $avatar ?>' class="img-responsive" />
                        </div>
                    </div>
                    <div class="col-xs-12 divider text-center">
                        <div class=" col-xs-12 col-sm-12 emphasis">
                            <h2><strong> <?php echo $nb_tweet ?> </strong></h2>
                            <p><small>Bêles</small></p>
                        </div>
                    </div>
                    <form id="form-tweet" action="?action=view_profile" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="identifiant" class="identifiant"value="<?php echo $identifiant_emetteur?>">
                        <input type="hidden" name="nom" class="nom" value="<?php echo $nom_emetteur?>">
                        <input type="hidden" name="prenom" class="prenom" value="<?php echo $prenom_emetteur?>">
                        <input type="hidden" name="avatar" class="avatar" value="<?php echo $avatar_emetteur?>">
                        <input type="hidden" name="last_tweet" class="last_tweet" value="<?php echo $tweet[0] -> id?>">
                        <textarea id="tweet" name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?" required></textarea>
                        <input id="submit" type="submit" value="Beler" >
                        <?php
                            if(isset($_REQUEST["pseudo"])){
                        ?>
                            <script>
                                var submit = document.getElementById("submit");
                                var textarea = document.getElementById("textarea");
                                submit.className = submit.className + " hidden-profile";
                                textarea.className = textarea.className + " hidden-profile";
                            </script>
                        <?php
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="container-goat1"></div>
                <?php
                $goat_user = tweetTable::getTweetsPostedBy($id_user);
                foreach($goat_user as $goat){
                    $id = $goat->id;
                    $emetteur = $goat -> emetteur;
                        $pseud_emetteur = utilisateurTable::getUserById($emetteur);
                        $parent_info = utilisateurTable::getUserById($goat -> getParent());
                        $pseudo_emetteur = $pseud_emetteur[0]->identifiant;
                        $nom_emetteur = $pseud_emetteur[0]->nom;
                        $prenom_emetteur = $pseud_emetteur[0]->prenom;
                    $post_emetteur = $goat->getPost();
                    $post_image = $post_emetteur[0] -> image;
                    if($post_image != "" && !file_exists($post_image))$post_image = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/goat.png";

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
                        $check = true;
                    }
                    else $check = false;

                    $nbvote = $goat -> getLikes();
                    if($emetteur != $goat -> parent) $check_rt = true;
                    else $check_rt = false;
                    $mon_id = context::getSessionAttribute("id");
                    $check_vote = voteTable::checkVoteByIdAndUser($id,$mon_id);
                ?>
                    <div class="container-goat">
                        <blockquote class="goat-box">
                            <?php
                                if($check_rt){
                            ?>
                                <div class = "user">
                                    <p class="rt">
                                        <?php
                                            echo "$pseudo_emetteur a retweeté ce tweet";
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
                                            <a href="?action=delete_tweet&id=<?php echo $id ?>&redirect=view_profile" class="glyphicon glyphicon-trash"></a>
                                        </p>

                                <?php
                                    }
                                ?>
                               <div class="goat-post">
                                    <p class="goat-text">
                                        <?php echo $post_emetteur[0] -> texte ?>
                                    </p>
                                    <img src="<?php echo $post_image; ?>" class="img-responsive">
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
                                            if($check_vote) echo "<a href='?action=deleteVote&id=$id&redirect=view_profile' class='red like glyphicon glyphicon-heart'>";
                                            else echo "<a href='?action=addVote&id=$id&redirect=view_profile' class='like glyphicon glyphicon-heart'>";
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
