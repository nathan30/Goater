<?php
    $usertab = new utilisateurmodel();
    $user = utilisateurTable::getUsers();
    $user2 = utilisateurTable::getUserById(620);
    $tweet = tweetTable::getTweets();
    $tweet2 = tweetTable::getTweetsPostedBy(362);
    $post = postTable::getPostById(46);
    echo $user2[0]->id;
    print_r($user);
    echo "<br><br>";
    print_r($user2);
    echo "<br><br>";
    print_r($tweet);
    echo "<br><br>";
    print_r($tweet2);
    echo "<br><br>";
    print_r($post);
?>
