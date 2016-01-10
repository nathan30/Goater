<?php
    if($_REQUEST["redirect"] == "view_profile"){
        context::redirect("?action=view_profile");
    }
    else{
        context::redirect('goater.php');
    }
?>
