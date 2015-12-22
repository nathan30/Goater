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
        }
        return context::SUCCESS;
    }

	public static function index($request,$context){
        $context->title = "Index";

        $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1');
        $id = context::getSessionAttribute("id");
        $user = utilisateurTable::getUserById($id)[0];
        context::setSessionAttribute("id",$user->id);
        context::setSessionAttribute("nom",$user->nom);
        context::setSessionAttribute("prenom",$user->prenom);
        context::setSessionAttribute("identifiant",$user->identifiant);
        context::setSessionAttribute("statut",$user->statut);
        context::setSessionAttribute("avatar",$user->avatar);
        context::setSessionAttribute("nb_tweet",$bdd -> query("SELECT COUNT (*) from jabaianb.tweet where emetteur=$user->id")->fetchColumn());

		return context::SUCCESS;
	}

    public static function view_profile($request,$context){
        if(context::getSessionAttribute("connect") != "true"){
            if($_REQUEST['id'] == 1){
                header('Location:goater.php?action=login&redirect=view_profile&id=1');
            }
            else{
                header('Location:goater.php?action=login');
            }
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
    public static function bele($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Bêle";
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
        echo $id;
        tweetTable::deleteTweetById($id);
       /* echo '<script language="javascript" type="text/javascript">
                window.location.replace("?action=view_profile");
              </script>';*/

        return context::SUCCESS;
    }
}
