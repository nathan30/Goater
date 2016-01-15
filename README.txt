CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php

Rendu final

Fonctions AJAX (Toutes regroupées dans js/script.js): 
	- Envoi de tweet
	- Modification de profil
	- Suppression de tweet
	- Affichage du nombre de nouveau tweet sur l'index
	- Ajout et Supression de vote sur un tweet

Fonctionnalitées supplémentaires :
	- Recherche de tweets contenant un mot via le formulaire à droite dans le menu (sensible à la casse)
	- Recherche d'utilisateur (par nom et/ou prénom, sensible à la casse) dans la page listant les utilisateurs
	- Possibilité de supprimer un tweet directement depuis le tweet lui-même (possible sur tout les tweets pour des questions pratique)
	- Erreur 404 pour la recherche d'un pseudo inexistant via l'url (par exemple)
	- Partage de tweets en cliquant sur l'heure d'un tweet (redirige vers une page affichant seulement ce tweet) 
	- Possibilité de RT un tweet, l'affichage du nouveau tweet créée est modifier afin d'afficher le pseudo de la personne ayant RT
	- Ajout d'une popup de notification de succès ou d'erreur (Tweet envoyé, profil mis à jour, tweet supprimé,ajout/suppression de vote)
	  dans le layout.php. Cette popup disparait automatiquement après quelques secondes

Autres infos : 
	- Le login et l'inscription sont réunis sur la même page (?action=login)
	- La modification du profil est effectué avec ?action=view_profile&edit=true. Ne fonctionne pas si un autre utilisateur est affiché
	  via le paramètres &pseudo=xxx
	- L'affichage d'un profil d'un utilisateur (autre que celui connecté) est effectué via le pseudo et non l'id (rajout de fonction 
	  getUserByPseudo)
	- Un loader est affiché avant que la page index (qui liste tout les tweet) soit affiché. Cela peut être long en fonction des images
	- Lors de la connexion, l'avatar de l'utilisateur est affiché sur la droite du menu. En cliquant dessus il est possible d'afficher,
	  de modifier le profil ou encore de se deconnecter
	- Le site est responsive (Affichage d'un background différent sur mobile, certains élements sont modifiés ou enlevés)