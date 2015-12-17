<?php
    class tweetmodel extends basemodel {
        function getPost($id){
            return postTable::getPostById($id);
        }
        function getParent($id){
            return utilisateurTable::getUserById($id);
        }
        function getLikes(){
            return $this->nbVotes;
        }
    }
?>
