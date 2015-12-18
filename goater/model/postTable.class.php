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
    }