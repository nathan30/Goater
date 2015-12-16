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
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Index";
        }
		return context::SUCCESS;
	}
    public static function view_profile($request,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Profil";

            $id = context::getSessionAttribute("id");
            $usertab = new utilisateurmodel();
            $user = utilisateurTable::getUserById($id);
            context::setSessionAttribute("nom",$user[0]->nom);
            context::setSessionAttribute("prenom",$user[0]->prenom);
            context::setSessionAttribute("identifiant",$user[0]->identifiant);
            context::setSessionAttribute("statut",$user[0]->statut);
            context::setSessionAttribute("avatar",$user[0]->avatar);
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
    public static function test($requet,$context){
        if(isset($_REQUEST['action'])){
            $context->action = $_REQUEST['action'];
            $context->title = "Test";
        }
        return context::SUCCESS;
    }
}
