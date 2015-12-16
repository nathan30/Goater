<?php
    class tweetmodel extends basemodel {
        function getPost(){
            return postTable::getPostById($id);
        }
        function getParent(){
            return utilisateurTable::getUserById($id);
        }
        function getLikes(){
            return $this->nbVotes;
        }
    }
?>
