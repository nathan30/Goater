<?php

class utilisateurTable {
    public static function getUserByLoginAndPass($login,$pass){
        $connection = new dbconnection() ;
        $sql = "select * from jabaianb.utilisateur where identifiant='".$login."' and pass='".sha1($pass)."'" ;

        $res = $connection->doQuery( $sql );

        if($res === false)
          return false ;

        return $res ;
    }

    public static function getUserById($id){
        $connection = new dbconnection();
        $sql = "select * from jabaianb.utilisateur where id='".$id."'";
        $res = $connection->doQueryObject($sql,'utilisateurmodel');
        if($res === false)
          return false ;
        return $res ;
    }

    public static function getUserByPseudo($pseudo){
        $connection = new dbconnection();
        $sql = "select * from jabaianb.utilisateur where identifiant='".$pseudo."'";
        $res = $connection->doQueryObject($sql,'utilisateurmodel');
        if($res === false)
          return false ;
        return $res ;
    }

    public static function getUsers(){
        $connection = new dbconnection();
        $sql = "select * from jabaianb.utilisateur";
        $res = $connection->doQueryObject($sql,'utilisateurmodel');
        if($res === false)
          return false ;
        return $res ;
    }
}
