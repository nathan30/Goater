<?php
    if($_REQUEST["redirect"] == "view_profile"){
        header('location:?action=view_profile');
    }
    else{
        header('location:goater.php');
    }
?>
