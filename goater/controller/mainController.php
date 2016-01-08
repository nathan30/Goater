<?php
/*
 * Controler
 */

class mainController
{
    public static function login($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            if(isset($_REQUEST['redirect'])){
                $context->redirect = $_REQUEST['redirect'];
            }
            $context->title = "Login";
        // <!-- ********** GOATER - LOGIN AND REGISTER - PHP ********** -->
            if($_SERVER['REQUEST_METHOD']==='POST' ){
                if(isset($_POST["login-submit"])){
                    if(isset($_POST["login"]) && isset($_POST["password"])){
                        if($res = utilisateurTable::getUserByLoginAndPass($_POST["login"],$_POST["password"])){
                            foreach($res as $r) {
                                $id = $r["id"];
                            }
                            context::setSessionAttribute("id",$id);
                            context::setSessionAttribute("connect","true");
                            if(isset($_REQUEST['redirect'])){
                                echo '<script language="javascript" type="text/javascript">
                                window.location.replace("goater.php?action='.$context->redirect.'&id=1");
                              </script>';
                            }
                            else{
                                echo '<script language="javascript" type="text/javascript">
                                window.location.replace("goater.php");
                              </script>';
                            }
                        }
                        else{
                            echo "<p class='goat-login-error'>Couple incorrect</p>";
                        }
                    }
                }
                if(isset($_POST["register-submit"])){
                    $prenom = $_POST["prenom"];
                    $nom = $_POST["nom"];
                    $login = $_POST["login"];
                    $password = sha1($_POST["password"]);
                    // ********** GOATER - LOGIN AND REGISTER - PHP - IMAGE TRANSFER **********
                    include 'goater/tools/upload_image.php';
                    // ********** END GOATER - LOGIN AND REGISTER - PHP - IMAGE TRANSFER **********
                    // ********** GOATER - LOGIN AND REGISTER - PHP - ADD IN DATABASE **********
                    if($uploadOk == 1){
                        $new_user = new utilisateur();
                        $new_user -> avatar = $target_file;
                        $new_user -> identifiant = $login;
                        $new_user -> pass = $password;
                        $new_user -> nom = $nom;
                        $new_user -> prenom = $prenom;
                        $new_user -> save();
                    }
                }
            }
        // <!-- ********** END GOATER - LOGIN AND REGISTER - PHP ********** -->
        return context::SUCCESS;
        }
    }

	public static function index($request,$context){
        context::setSessionAttribute("nb_tweet_init", tweetTable::countTweet());
        $context->title = "Index";
        if(context::getSessionAttribute("connect") != "true"){
            header('Location:goater.php?action=login');
        }

        $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1'); // Utilisation de cette connexion au lieu de dbconnection() pour l'utilisation du fetchColumn();
        $id = context::getSessionAttribute("id");
        $user = utilisateurTable::getUserById($id)[0];
        context::setSessionAttribute("id",$user->id);
        context::setSessionAttribute("nom",$user->nom);
        context::setSessionAttribute("prenom",$user->prenom);
        context::setSessionAttribute("identifiant",$user->identifiant);
        context::setSessionAttribute("statut",$user->statut);
        context::setSessionAttribute("avatar",$user->avatar);
        context::setSessionAttribute("nb_tweet",$bdd -> query("SELECT COUNT (*) from jabaianb.tweet where emetteur=$user->id")->fetchColumn());

        if(isset($_POST["tweet"])){
            tweetTable::sendTweet($_POST["tweet"]);
        }

		return context::SUCCESS;
	}

    public static function view_profile($request,$context){
        if(context::getSessionAttribute("connect") != "true"){
            header('Location:goater.php?action=login');
        }
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Profil";
            $id = context::getSessionAttribute("id");
            $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1');
            if(isset($_REQUEST["pseudo"])){
                if(utilisateurTable::getUserByPseudo($_REQUEST["pseudo"]) == false){
                    echo '<script language="javascript" type="text/javascript">
                            window.location.replace("goater.php?action=erreur_404");
                          </script>';
                }
                $context->pseudo_url = $_REQUEST["pseudo"];
                $user = utilisateurTable::getUserByPseudo($context->pseudo_url)[0];
                $context->nom = $user->nom;
                $context->prenom = $user->prenom;
                $context->identifiant = $user->identifiant;
                $context->statut = $user->statut;
                $context->avatar = $user->avatar;
                $context->id_user = $user->id;
                $context->nb_tweet = $bdd -> query("SELECT COUNT (*) from jabaianb.tweet where emetteur=$user->id")->fetchColumn();
            }
            else{
                $user = utilisateurTable::getUserById($id)[0];
                context::setSessionAttribute("id",$user->id);
                context::setSessionAttribute("nom",$user->nom);
                context::setSessionAttribute("prenom",$user->prenom);
                context::setSessionAttribute("identifiant",$user->identifiant);
                context::setSessionAttribute("statut",$user->statut);
                context::setSessionAttribute("avatar",$user->avatar);
                context::setSessionAttribute("nb_tweet",$bdd -> query("SELECT COUNT (*) from jabaianb.tweet where emetteur=$user->id")->fetchColumn());
                if(isset($_REQUEST["edit"]) && $_REQUEST["edit"] == "true" && !isset($_REQUEST["pseudo"])){
                    if(isset($_POST["statut_update"]) && isset($_POST["nom_update"]) && isset($_POST["prenom_update"])){
                        $statut_update = $_POST["statut_update"];
                        $prenom_update = $_POST["prenom_update"];
                        $nom_update = $_POST["nom_update"];
                        include 'goater/tools/upload_image.php';
                            if($uploadOk == 1){
                                $user -> avatar = $target_file;
                            }
                        $user -> statut = $statut_update;
                        $user -> prenom = $prenom_update;
                        $user -> nom = $nom_update;
                        $user -> save();

                        echo '<script language="javascript" type="text/javascript">
                            window.location.replace("?action=view_profile");
                          </script>';
                    }
                }
            }
            if(isset($_POST["tweet"])){
                tweetTable::sendTweet();
            }

        }
		return context::SUCCESS;
	}
    public static function liste_user($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Liste";
        }
		return context::SUCCESS;
	}
    public static function disconnect($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Déconnexion";
        }
		return context::SUCCESS;
	}
    public static function erreur_404($requet,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Erreur 404";
        }
        return context::SUCCESS;
    }
    public static function delete_tweet($request,$context){
        $id = $_REQUEST["id"];
        tweetTable::deleteTweetById($id);
        return context::SUCCESS;
    }
    public static function share_tweet($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Partage de Tweet";
            if(isset($_REQUEST["id"])){
                $context -> tweet_share = tweetTable::getTweetById($_REQUEST["id"]);
            }
        }
        return context::SUCCESS;
    }
    public static function search($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = $_REQUEST["q"];
        }
        return context::SUCCESS;
    }
    public static function addVote($request,$context){
        if(isset($_REQUEST['action']) && isset($_REQUEST['id'])){
            voteTable::addVoteById($_REQUEST["id"]);
        }
        return context::SUCCESS;
    }
    public static function deleteVote($request,$context){
        if(isset($_REQUEST['action']) && isset($_REQUEST['id'])){
            voteTable::delVoteById($_REQUEST["id"]);
        }
        return context::SUCCESS;
    }
    public static function rtTweet($request,$context){
        if(isset($_REQUEST['action']) && isset($_REQUEST['id'])){
            tweetTable::rtTweetById($_REQUEST["id"]);
            echo '<script language="javascript" type="text/javascript">
                    window.location.replace("goater.php");
                  </script>';
        }
        return context::SUCCESS;
    }


    //Fonction AJAX

    public static function AjaxCreateTweet($request,$context){
        tweetTable::sendTweet();
        return context::NONE;
    }
    public static function AjaxLikeTweet($request,$context){
        voteTable::addVoteById($_REQUEST["id"]);
        return context::NONE;
    }
    public static function AjaxDeleteLikeTweet($request,$context){
        voteTable::delVoteById($_REQUEST["id"]);
        return context::NONE;
    }
    public static function AjaxUpdateProfil($request,$context){
        if(isset($_REQUEST["edit"]) && $_REQUEST["edit"] == "true" && !isset($_REQUEST["pseudo"])){
            if(isset($_POST["statut_update"]) && isset($_POST["nom_update"]) && isset($_POST["prenom_update"])){
                $statut_update = $_POST["statut_update"];
                $prenom_update = $_POST["prenom_update"];
                $nom_update = $_POST["nom_update"];
                $id = context::getSessionAttribute("id");

                $user = utilisateurTable::getUserById($id)[0];
                $user -> statut = $statut_update;
                $user -> prenom = $prenom_update;
                $user -> nom = $nom_update;
                $user -> save();
            }
        }
        return context::NONE;
    }
    public static function AjaxDeleteTweet($request,$context){
        tweetTable::deleteTweetById($_REQUEST["id"]);
        return context::SUCCESS;
    }
    public static function AjaxViewNumberNewTweet($request,$context){
        $current_tweet = tweetTable::countTweet();
        $nb_tweet_init = context::getSessionAttribute("nb_tweet_init");
        if($nb_tweet_init != $current_tweet){
            $nb_new_tweet = $current_tweet - $nb_tweet_init;
        }else $nb_new_tweet = 0;
        echo json_encode(array('new_tweet' => $nb_new_tweet));
        return context::NONE;
    }


}
