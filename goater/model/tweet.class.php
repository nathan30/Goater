<?php
    class tweet extends basemodel {
        function getPost(){
            return postTable::getPostById($this->post);
        }
        function getParent(){
            return utilisateurTable::getUserById($this->parent);
        }
        function getLikes(){
            return $this->nbvotes;
        }
    }
?>
