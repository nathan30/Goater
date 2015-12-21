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
        function getTweetsPostedBy($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where emetteur='".$id."' order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        public function sendTweet($request){
            $connection = new dbconnection();
            $datePost = date('d-m-Y, H:i:s');
            $sql = "INSERT INTO jabaianb.post (texte, date) VALUES('" . $_REQUEST['tweet'] . "','" . $datePost . "')";
            $res = $connection->doExec($sql);

            $sql = "SELECT * FROM jabaianb.post WHERE date='" . $datePost . "'";
            $resPost = $connection->doQueryObject($sql, 'post');

            $sql = "INSERT INTO jabaianb.tweet (emetteur, parent, post, nbvotes) VALUES('" . $_SESSION['id'] . "','" . $_SESSION['id'] . "','" . $resPost[0]->id . "','0')";
            $res2 = $connection->doExec($sql);

            $sql = "SELECT * FROM jabaianb.tweet WHERE post='" . $resPost[0]->id . "'";
            $resTweet = $connection->doQueryObject($sql, 'tweet');

            if ($resPost === false || $resTweet === false) {
                return false;
            }

            return true;
        }
    }
