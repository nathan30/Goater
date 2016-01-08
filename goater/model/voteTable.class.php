<?php

class voteTable {
        public function addVoteById($id){
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where id='".$id."'";
            $res = $connection->doQueryObject($sql,'tweet');

            $id_user = context::getSessionAttribute("id");
            $sql = "INSERT INTO jabaianb.vote (utilisateur, message) VALUES('$id_user','$id')";
            $resVote = $connection->doExec($sql);
            $nbvote_init = $res[0] -> nbvotes;
            $nbvote = $nbvote_init + 1;
            $res[0] -> nbvotes = $nbvote;
            $res[0] -> save();
        }
        public function delVoteById($id){
            $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1');
            $connection = new dbconnection();
            $sql = "select * from jabaianb.tweet where id=$id";
            $res = $connection->doQueryObject($sql,'tweet');

            $id_user = context::getSessionAttribute("id");
            $sql = "DELETE from jabaianb.vote where utilisateur = $id_user AND message = $id";
            $resVote = $connection->doExec($sql);

            $nbvote_init = $res[0] -> nbvotes;
            if($nbvote_init == 1) $update = $bdd -> query("UPDATE jabaianb.tweet set nbvotes='0'");
            else $nbvote = $nbvote_init - 1;
            $res[0] -> nbvotes = $nbvote;
            $res[0] -> save();
        }
        public function checkVoteByIdAndUser($id,$user){
            $connection = new dbconnection();
            $sql = "SELECT * FROM jabaianb.vote where utilisateur = $user AND message = $id";
            $res = $connection->doQueryObject($sql,'vote');
            if($res == false) return false;
            else return true;
        }
}
