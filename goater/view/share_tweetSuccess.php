<?php
    $tweet = $context -> tweet_share;
    $id = $tweet[0] -> id;
    $post_emetteur = $tweet[0] -> getPost();
        $parent_info = utilisateurTable::getUserById($tweet[0] -> getParent());
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
        $nbvote = $tweet[0] -> getLikes();
        $id_user = context::getSessionAttribute("id");
        $check_vote = tweetTable::checkVoteByIdAndUser($id,$id_user);

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
                if($check == true){
                    setlocale (LC_TIME, 'fr_FR.utf8','fra');
                    $date_post = $post_emetteur[0] -> date;
                    $format_date = explode(" ",$date_post);
                    $date = DateTime::createFromFormat('Y-m-d', $format_date[0]);
                    $heure = DateTime::createFromFormat('H:i:s',$format_date[1]);
                    echo $date -> format('l d M ');
                    echo $heure -> format('H:i');
                }
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
        <?php
            if($check_vote) echo "<a class='red like glyphicon glyphicon-heart'></a>";
            else echo "<a href='?action=addVote&id=$id' class='like glyphicon glyphicon-heart'></a>";
        ?>
            <span class="badge quote-badge"><?php echo $nbvote ?></span>
            <a href="?action=rtTweet&id=<?php echo $id?>" class="retweet glyphicon glyphicon-retweet" onclick="return(confirm('Etes-vous sûr de vouloir retweeter ce goat ?'));"></a>
        </p>
    </div>
</blockquote>
