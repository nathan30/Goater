<?php
    // ********** GOATER - LOGIN AND REGISTER - PHP - IMAGE TRANSFER **********
    $target_dir = "mvc/images/avatar/";
    $target_file = "https://pedago02a.univ-avignon.fr/~uapv1402577/".$target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["register-submit"])){
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<p class='goat-login-error'>Le fichier n'est pas une image.</p>";
            $uploadOk = 0;
        }
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
        echo "<p class='goat-login-error'>Désolé, uniquement les extensions suivantes sont autorisées JPG, JPEG, PNG & GIF</p>";
        $uploadOk = 0;
    }
    if ($uploadOk == 0){
        echo "<p class='goat-login-error'>Désolé, votre fichier n'as pas été uploadé.</p>";
    }
    else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)){
            echo "<p class='goat-login-error'>Inscription validée</p>";
        }
        else {
            echo "<p class='goat-login-error'>Désolé, une erreur s'est produite pendant l'upload de votre fichier.</p>";
        }
    }
?>
