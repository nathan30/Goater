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
        $res = $connection->doQueryObject($sql,'utilisateur');
        if($res === false)
          return false ;
        return $res ;
    }

    public static function getUserByPseudo($pseudo){
        $connection = new dbconnection();
        $sql = "select * from jabaianb.utilisateur where identifiant='".$pseudo."'";
        $res = $connection->doQueryObject($sql,'utilisateur');
        if($res === false)
          return false ;
        return $res ;
    }

    public static function getUsers(){
        $connection = new dbconnection();
        $sql = "select * from jabaianb.utilisateur order by id DESC";
        $res = $connection->doQueryObject($sql,'utilisateur');
        if($res === false)
          return false ;
        return $res ;
    }

    public static function getUserByFirstNameOrLastName($request){
        $connection = new dbconnection();
        $sql = "SELECT * FROM jabaianb.utilisateur where nom like '%$request%' OR prenom like '%$request%' order by id DESC";
        $res = $connection->doQueryObject($sql,'utilisateur');
        if($res === false)
          return false ;
        return $res ;
    }
}
