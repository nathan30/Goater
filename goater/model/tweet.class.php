<?php
    class tweet extends basemodel {
        function getPost(){
            return postTable::getPostById($this->post);
        }
        function getParent(){
            return  $this->data['parent'];
        }
        function getLikes(){
            return $this->nbvotes;
        }
    }
