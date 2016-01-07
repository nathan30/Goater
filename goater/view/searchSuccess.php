<?php
    if(isset($_REQUEST["q"])){
        $post_list = postTable::getPostByHashTag($_REQUEST["q"]);
        foreach($post_list as $post){
            $id_post = $post -> id;
            $tweet_list = tweetTable::getTweetsByPostId($id_post);
            foreach($tweet_list as $tweet){
                $id = $tweet->id;
                $parent_info = utilisateurTable::getUserById($tweet -> getParent());
                $emetteur_info = utilisateurTable::getuserById($tweet -> emetteur);
                $post_emetteur = $tweet->getPost();
                $post_image = $post_emetteur[0] -> image;
                if($post_image != "" && !file_exists($post_image)){
                    $post_image = "https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/images/goat.png";
                }
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
                $nbvote = $tweet -> getLikes();
                if($tweet -> emetteur != $tweet -> parent) $check_rt = true;
                else $check_rt = false;
                $id_user = context::getSessionAttribute("id");
                $check_vote = voteTable::checkVoteByIdAndUser($id,$id_user);
?>
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
                    <img src="<?php echo $post_image; ?>" class="img-responsive">
                    <a href="?action=share_tweet&id=<?php echo $id?>" class="goat-time">
                        <?php
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
                <div class = "user">
                    <?php
                        if($check) echo "<img src='$avatar_parent' class='img-responsive'>";
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
                            <p class="blog-post-bottom pull-right">
                            <?php
                                if($check_vote) echo "<a href='?action=deleteVote&id=$id&redirect=view_profile' class='red like glyphicon glyphicon-heart'>";
                                else echo "<a href='?action=addVote&id=$id' class='like glyphicon glyphicon-heart'>";
                            ?>
                                <span class="badge quote-badge"><?php echo $nbvote ?></span></a>
                                <?php
                                    $id_user = context::getSessionAttribute("id");
                                    if($tweet -> emetteur != $id_user){
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
                </blockquote>
<?php
            }
        }
    }
?>
