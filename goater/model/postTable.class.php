<?php
    class postTable {
        function getPostById($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.post where id='".$id."'";
            $res = $connection->doQueryObject($sql,'post');
            if($res === false)
              return false ;
            return $res ;
        }

        function getPostByHashTag($hashtag){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.post where texte like '%$hashtag%' order by id DESC";
            $res = $connection->doQueryObject($sql,'tweet');
            if($res === false)
              return false ;
            return $res;

        }
    }
