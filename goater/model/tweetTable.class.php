<?php
    class tweetTable{
        function getTweets(){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
        function getTweetsPostedBy($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where emetteur='".$id."'";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res ;
        }
    }
?>
