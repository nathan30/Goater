<?php
/*
 * Controler
 */

class mainController
{
    public static function login($request,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Login";
            if(context::getSessionAttribute("connect") == "true"){
                context::redirect('goater.php');
            }
        // <!-- ********** GOATER - LOGIN AND REGISTER - PHP ********** -->
            if(isset($request["login-submit"])){
                if(isset($request["login"]) && isset($request["password"])){
                    echo 'bb';
                    if($res = utilisateurTable::getUserByLoginAndPass($request["login"],$request["password"])){
                        echo 'a';
                        foreach($res as $r) {
                            $id = $r["id"];
                        }
                        context::setSessionAttribute("id",$id);
                        context::setSessionAttribute("connect","true");
                        if(isset($request['redirect'])){
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
            if(isset($request["register-submit"])){
                $prenom = $request["prenom"];
                $nom = $request["nom"];
                $login = $request["login"];
                $password = sha1($request["password"]);
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
        // <!-- ********** END GOATER - LOGIN AND REGISTER - PHP ********** -->
        return context::SUCCESS;
        }
    }

	public static function index($request,$context){
        context::setSessionAttribute("nb_tweet_init", tweetTable::countTweet());
        $context->title = "Index";
        if(context::getSessionAttribute("connect") != "true"){
            context::redirect("goater.php?action=login");
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

        if(isset($request["tweet"])){
            tweetTable::sendTweet($request["tweet"]);
        }

		return context::SUCCESS;
	}

    public static function view_profile($request,$context){
        if(context::getSessionAttribute("connect") != "true"){
            context::redirect("goater.php?action=login");
        }
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Profil";
            $id = context::getSessionAttribute("id");
            $bdd = new PDO('pgsql:host=localhost dbname=etd user=uapv1402577 password=jenYv1');
            if(isset($request["pseudo"])){
                if(!utilisateurTable::getUserByPseudo($request["pseudo"])){
                    echo '<script language="javascript" type="text/javascript">
                            window.location.replace("goater.php?action=erreur_404");
                          </script>';
                }
                $context->pseudo_url = $request["pseudo"];
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
                if(isset($request["edit"]) && $request["edit"] == "true" && !isset($request["pseudo"])){
                    if(isset($request["statut_update"]) && isset($request["nom_update"]) && isset($request["prenom_update"])){
                        $statut_update = $request["statut_update"];
                        $prenom_update = $request["prenom_update"];
                        $nom_update = $request["nom_update"];
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
            if(isset($request["tweet"])){
                tweetTable::sendTweet($request["tweet"]);
            }

        }
		return context::SUCCESS;
	}
    public static function liste_user($request,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Liste";
        }
		return context::SUCCESS;
	}
    public static function disconnect($request,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Déconnexion";
        }
		return context::SUCCESS;
	}
    public static function erreur_404($requet,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Erreur 404";
        }
        return context::SUCCESS;
    }
    public static function delete_tweet($request,$context){
        $id = $request["id"];
        tweetTable::deleteTweetById($id);
        return context::SUCCESS;
    }
    public static function share_tweet($request,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = "Partage de Tweet";
            if(isset($request["id"])){
                $context -> tweet_share = tweetTable::getTweetById($request["id"]);
            }
        }
        return context::SUCCESS;
    }
    public static function search($request,$context){
        if(isset($request['action'])){
            $context->action = $request['action'];
            $context->title = $request["q"];
        }
        return context::SUCCESS;
    }
    public static function addVote($request,$context){
        if(isset($request['action']) && isset($request['id'])){
            voteTable::addVoteById($request["id"]);
        }
        return context::SUCCESS;
    }
    public static function deleteVote($request,$context){
        if(isset($request['action']) && isset($request['id'])){
            voteTable::delVoteById($request["id"]);
        }
        return context::SUCCESS;
    }
    public static function rtTweet($request,$context){
        if(isset($request['action']) && isset($request['id'])){
            tweetTable::rtTweetById($request["id"]);
            echo '<script language="javascript" type="text/javascript">
                    window.location.replace("goater.php");
                  </script>';
        }
        return context::NONE;
    }


    //Fonction AJAX

    public static function AjaxCreateTweet($request,$context){
        tweetTable::sendTweet($request["tweet"]);
        return context::NONE;
    }
    public static function AjaxLikeTweet($request,$context){
        voteTable::addVoteById($request["id"]);
        return context::NONE;
    }
    public static function AjaxDeleteLikeTweet($request,$context){
        voteTable::delVoteById($request["id"]);
        return context::NONE;
    }
    public static function AjaxUpdateProfil($request,$context){
        if(isset($request["edit"]) && $request["edit"] == "true" && !isset($request["pseudo"])){
            if(isset($request["statut_update"]) && isset($request["nom_update"]) && isset($request["prenom_update"])){
                $statut_update = $request["statut_update"];
                $prenom_update = $request["prenom_update"];
                $nom_update = $request["nom_update"];
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
        tweetTable::deleteTweetById($request["id"]);
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
