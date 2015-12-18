<?php
    class tweetmodel extends basemodel {
        function getPost(){
            return postTable::getPostById($this->post);
        }
        function getParent(){
            return $this->parent;
        }
        function getLikes(){
            return $this->nbvotes;
        }
    }
?>
