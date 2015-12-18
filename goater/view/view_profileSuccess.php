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
// <!-- ********** END GOATER - RETRIEVE DATA ********** -->

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            <div class="well profile">
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-8">
                        <h2>
                            <?php
                                echo "$nom $prenom";
                            ?>
                        </h2>
                        <p><strong>Pseudo: </strong><?php echo "@$identifiant"?></p>
                        <?php
                            if(!isset($_POST["statut"])){

                            }
                        ?>
                        <p><strong>Statut: </strong>
                            <?php echo $statut;?>
                        </p>
                        <?php
                            if(isset($_REQUEST["edit"]) && $_REQUEST["edit"] == "true" ){
                               echo"<form action='?action=view_profile&edit=true' method='POST'>
                                        <textarea name='statut_update' rows='4' class='form-control' maxlength='100' style='resize:none'></textarea>
                                        <input type='submit'>
                                    </form>";
                            }
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 text-center">
                        <object data=<?php echo $avatar ?> type="image/png" class="img-responsive">
                            <img src='https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/avatar/default.png' alt='photo default' class="img-responsive"/>
                        </object>
                    </div>
                </div>
                <div class="col-xs-12 divider text-center">
                    <div class=" col-xs-12 col-sm-12 emphasis">
                        <h2><strong> <?php echo $nb_tweet ?> </strong></h2>
                        <p><small>Bêles</small></p>
                    </div>
                </div>
                <form action="?action=view_profile" method="POST">
                    <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?"><?php if(isset($_REQUEST["pseudo"]))echo "@$identifiant ";?></textarea>
                    <input type="submit" value="Beler">
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
                    $parent = $goat -> parent;
                    $post_emetteur = $goat->getPost();
                    $nbvote = $goat -> getLikes();
            ?>
                    <blockquote class="goat-box">
                        <p class="goat-text">
                            <?php echo $post_emetteur[0] -> texte ?>
                        </p>
                        <hr>
                        <div class="blog-post-actions">
                            <p class="goat-author blog-post-bottom pull-left">
                                <?php echo "$prenom_emetteur $nom_emetteur " ?><a href="?action=view_profile&pseudo=<?php echo $pseudo_emetteur ?>" target="_blank"><?php echo "@$pseudo_emetteur" ?></a>
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
