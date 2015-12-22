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

 // <!-- ********** END GOATER - RETRIEVE DATA ********** -->
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <?php
                if(isset($_REQUEST["edit"]) && $_REQUEST["edit"] == "true" && !isset($_REQUEST["pseudo"])){
                    $size = "col-md-6";
            ?>
                    <form action='?action=view_profile&edit=true' method='POST' enctype="multipart/form-data">
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
                            <textarea name='statut_update' rows='4' class='form-control' maxlength='100' style='resize:none'><?php echo $statut ?></textarea>
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
            <div class="<?php echo $size ?>">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <h2>
                            <?php
                                echo "$nom $prenom";
                            ?>
                        </h2>
                            <p><strong>Pseudo: </strong>
                                <?php echo "@$identifiant"?>
                            </p>
                            <p><strong>Statut: </strong>
                                <?php echo $statut;?>
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
                    <form action="?action=view_profile" method="POST" enctype="multipart/form-data">
                        <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?"><?php if(isset($_REQUEST["pseudo"]))echo "@$identifiant ";?></textarea>
                        <input type="file" name="avatar">
                        <input type="submit" value="Beler">
                        <?php
                        if(isset($_POST["tweet"])){
                            tweetTable::sendTweet($_POST["tweet"]);
                        }
                    ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php
                $goat_user = tweetTable::getTweetsPostedBy($id_user);
                foreach($goat_user as $goat){
                    $id = $goat->id;
                    $emetteur = $goat -> emetteur;
                        $pseud_emetteur = utilisateurTable::getUserById($emetteur);
                        $pseudo_emetteur = $pseud_emetteur[0]->identifiant;
                        $nom_emetteur = $pseud_emetteur[0]->nom;
                        $prenom_emetteur = $pseud_emetteur[0]->prenom;
                    $post_emetteur = $goat->getPost();

                    $nbvote = $goat -> getLikes();
                ?>
                    <blockquote class="goat-box">
                        <p class="pull-right">
                            <a href="?action=delete_tweet&id=<?php echo $id ?>&redirect=view_profile" class="glyphicon glyphicon-trash" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce goat ?'));"></a>
                        </p>
                        <div class="goat-post">
                            <p class="goat-text">
                                <?php echo $post_emetteur[0] -> texte ?>
                            </p>
                            <img src="<?php echo $post_emetteur[0] -> image ?>" class="img-responsive">
                            <a href="?action=share_tweet&id=<?php echo $id?>" class="goat-time">
                                <?php
                                    setlocale (LC_TIME, 'fr_FR.utf8','fra');
                                    $date_post = $post_emetteur[0] -> date;
                                    $format_date = explode(" ",$date_post);
                                    $date = DateTime::createFromFormat('Y-m-d', $format_date[0]);
                                    $heure = DateTime::createFromFormat('H:i:s',$format_date[1]);
                                    echo $date -> format('l d M ');
                                    echo $heure -> format('H:i');
                                ?>
                            </a>
                        </div>

                        <hr>
                        <div class="blog-post-actions">
                            <p class="goat-author blog-post-bottom pull-left">
                                <?php echo "$prenom_emetteur $nom_emetteur " ?>
                                    <a href="?action=view_profile&pseudo=<?php echo $pseudo_emetteur ?>" target="_blank">
                                        <?php echo "@$pseudo_emetteur" ?>
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
        </div>
    </div>
