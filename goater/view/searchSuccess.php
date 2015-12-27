<?php
    if(isset($_REQUEST["q"])){
        $post_list = postTable::getPostByHashTag($_REQUEST["q"]);
        foreach($post_list as $post){
            $id_post = $post -> id;
            $tweet_list = tweetTable::getTweetsByPostId($id_post);
            foreach($tweet_list as $tweet){
                $parent_info = utilisateurTable::getUserById($tweet -> getParent());
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
?>
                <blockquote class="goat-box">
                <p class="pull-right">
                    <a href="?action=delete_tweet&id=<?php echo $id ?>&redirect=index" class="glyphicon glyphicon-trash" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce goat ?'));"></a>
                </p>
                <div class="goat-post">
                    <p class="goat-text">
                        <?php echo $post_emetteur[0] -> texte ?>
                    </p>
                    <img src="<?php echo $post_image; ?>" class="img-responsive">
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
                    <p class="blog-post-bottom pull-right">
                        <span class="badge quote-badge"><?php echo $nbvote ?></span>
                        <a class="like glyphicon glyphicon-heart"></a>
                    </p>
                </div>
                </blockquote>
<?php
            }
        }
    }
?>
