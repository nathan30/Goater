<?php
    if(isset($_REQUEST["id"])){
        $id = $_REQUEST["id"];
    }
    if(context::getSessionAttribute("connect") != "true"){
        if($id == 1){
            header('Location:goater.php?action=login&redirect=view_profile&id=1');
        }
        else{
            header('Location:goater.php?action=login');
        }
    }

// <!-- ********** GOATER - RETRIEVE DATA ********** -->

    $nom = context::getSessionAttribute("nom");
    $prenom = context::getSessionAttribute("prenom");
    $identifiant = context::getSessionAttribute("identifiant");
    $statut = context::getSessionAttribute("statut");
    $avatar = context::getSessionAttribute("avatar");
    $id_user = context::getSessionAttribute("id");

// <!-- ********** END GOATER - RETRIEVE DATA ********** -->

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            <div class="well profile">
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-8">
                        <h2>
                            <?php
                                echo "$nom $prenom";
                            ?>
                        </h2>
                        <p><strong>Pseudo: </strong><?php echo "@$identifiant"?></p>
                        <?php
                            if(!isset($_POST["statut"])){

                            }
                        ?>
                        <p><strong>Statut: </strong>
                            <?php echo $statut?>
                        </p>
                        <?php
                            if(isset($_REQUEST["id"])){
                                $id = $_REQUEST["id"];
                                if($id == 1){
                                    echo"<form action='?action=view_profile&id=1' method='POST'>
                                        <textarea name='statut_update' rows='4' class='form-control' maxlength='160' style='resize:none'>$statut</textarea>
                                        <input type='submit'>
                                    </form>";
                                }
                            }
                            if(isset($_POST["statut_update"])){
                                $statut_update=$_POST["statut_update"];
                                $connection = new dbconnection() ;
                                $update = $connection -> doQuery("UPDATE jabaianb.utilisateur set statut='$statut_update' where id='$id_user'");
                            }
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 text-center">
                        <img src="images/ktm.jpg" class="img-responsive">
                    </div>
                </div>
                <div class="col-xs-12 divider text-center">
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> 20,7K </strong></h2>
                        <p><small>Bêles</small></p>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> 2K </strong></h2>
                        <p><small>Moutons</small></p>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong>245</strong></h2>
                        <p><small>Bergers</small></p>
                    </div>
                </div>
                <?php
                    if(isset($_REQUEST["id"])){
                        $id = $_REQUEST["id"];
                        if($id != 1){
                            $tweet = "@$identifiant ";
                        }
                    }
                ?>
                    <form action="?action=view_profile" method="POST">
                        <textarea name="tweet" rows="3" class="form-control" maxlength="140" style="resize:none" placeholder="Quoi de neuf ?"><?php if(isset($tweet))echo $tweet;?></textarea>
                        <input type="submit" value="Beler">
                    </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                include 'goater/view/beleSuccess.php';
            ?>
        </div>
    </div>
</div>
