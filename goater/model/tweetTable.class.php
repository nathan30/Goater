<?php
    class tweetTable{
        function getTweets(){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        function getTweetById($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where id=$id order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        function getTweetsPostedBy($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where emetteur='".$id."' order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        function getTweetsByPostId($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where post='".$id."' order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        public function sendTweet($tweet_message){
            $connection = new dbconnection();
            $datePost = date('d-m-Y, H:i:s');
            $id = context::getSessionAttribute("id");
            include 'goater/tools/upload_image.php';
            $uploadOk = 1;
            if($uploadOk == 1){
                $sql = "INSERT INTO jabaianb.post (texte, date,image) VALUES('$tweet_message','$datePost','".$request['image']."')";
            }
            else{
                $sql = "INSERT INTO jabaianb.post (texte, date) VALUES('$tweet_message','$datePost')";
            }
            $res = $connection->doExec($sql);

            $sql = "SELECT * FROM jabaianb.post WHERE date='$datePost'";
            $resPost = $connection->doQueryObject($sql, 'post');

            $sql = "INSERT INTO jabaianb.tweet (emetteur, parent, post, nbvotes) VALUES('$id','$id','".$resPost[0]->id."','0')";
            $res2 = $connection->doExec($sql);

            $sql = "SELECT * FROM jabaianb.tweet WHERE post='".$resPost[0]->id."'";
            $resTweet = $connection->doQueryObject($sql, 'tweet');

            if ($resPost === false || $resTweet === false) {
                return false;
            }
            return true;
        }
        public function deleteTweetById($id){
            $tweet = tweetTable::getTweetById($id);
            $id_post = $tweet[0] -> post;
            $connection = new dbconnection();
            $sql = "delete from jabaianb.tweet where id='".$id."'";
            $res = $connection->doExec($sql);

            $sql = "delete from jabaianb.post where id='".$id_post."'";
            $res = $connection->doExec($sql);
            if($res === false)
              return false ;
            return $res ;
        }

        public function rtTweetById($id){
            $connection = new dbconnection();
            $datePost = date('d-m-Y, H:i:s');
            $sql = "select * from jabaianb.tweet where id='".$id."'";
            $res = $connection->doQueryObject($sql,'tweet');
            $parent = $res[0] -> parent;
            $id_post = $res[0] -> post;
            $emetteur = context::getSessionAttribute("id");
            $sql = "INSERT INTO jabaianb.tweet (emetteur, parent, post, nbvotes) VALUES('$emetteur','$parent','$id_post','0')";
            $res = $connection->doExec($sql);
        }
        public function countTweet(){
            $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1'); // Utilisation de cette connexion au lieu de dbconnection() pour l'utilisation du fetchColumn();
            $res = $bdd -> query("SELECT COUNT (*) from jabaianb.tweet")->fetchColumn();
            if($res === false)
                return false ;
            return $res ;
        }

    }
