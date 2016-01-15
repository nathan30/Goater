CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php

Rendu final

Fonctions AJAX (Toutes regroup�es dans js/script.js): 
	- Envoi de tweet
	- Modification de profil
	- Suppression de tweet
	- Affichage du nombre de nouveau tweet sur l'index
	- Ajout et Supression de vote sur un tweet

Fonctionnalit�es suppl�mentaires :
	- Recherche de tweets contenant un mot via le formulaire � droite dans le menu (sensible � la casse)
	- Recherche d'utilisateur (par nom et/ou pr�nom, sensible � la casse) dans la page listant les utilisateurs
	- Possibilit� de supprimer un tweet directement depuis le tweet lui-m�me (possible sur tout les tweets pour des questions pratique)
	- Erreur 404 pour la recherche d'un pseudo inexistant via l'url (par exemple)
	- Partage de tweets en cliquant sur l'heure d'un tweet (redirige vers une page affichant seulement ce tweet) 
	- Possibilit� de RT un tweet, l'affichage du nouveau tweet cr��e est modifier afin d'afficher le pseudo de la personne ayant RT
	- Ajout d'une popup de notification de succ�s ou d'erreur (Tweet envoy�, profil mis � jour, tweet supprim�,ajout/suppression de vote)
	  dans le layout.php. Cette popup disparait automatiquement apr�s quelques secondes

Autres infos : 
	- Le login et l'inscription sont r�unis sur la m�me page (?action=login)
	- La modification du profil est effectu� avec ?action=view_profile&edit=true. Ne fonctionne pas si un autre utilisateur est affich�
	  via le param�tres &pseudo=xxx
	- L'affichage d'un profil d'un utilisateur (autre que celui connect�) est effectu� via le pseudo et non l'id (rajout de fonction 
	  getUserByPseudo)
	- Un loader est affich� avant que la page index (qui liste tout les tweet) soit affich�. Cela peut �tre long en fonction des images
	- Lors de la connexion, l'avatar de l'utilisateur est affich� sur la droite du menu. En cliquant dessus il est possible d'afficher,
	  de modifier le profil ou encore de se deconnecter
	- Le site est responsive (Affichage d'un background diff�rent sur mobile, certains �lements sont modifi�s ou enlev�s)