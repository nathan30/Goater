CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/

index.php dans /inscription est utilisé seulement pour l'inscription

Le login est effectué grâce à la méthode login

Dans la vue du profil, la gestion des avatar (ajout d'un avatar par défaut si pas d'avatar sur le profil) sera ajouté dès l'accès à la BDD

La liste est pour le moment statique, et amène à la view_profile avec un paramètre supplémentaire "id". Cette ID permet seulement, pour le moment,
de définir si le profil est vu par l'utilisateur logué ou pas. L'input servant de modification du statut est affiché ou pas. Le pseudo est 
également rajouté dans le formulaire du tweet si c'est le profil d'un autre utilisateur

La template Tweet est implémenté dans view_profile avec un include. La gestion de l'affichage (si utilisateur logué etc..) sera géré dès
l'accès à la BDD. Un bouton like et RT sont cliquable (et en fonction dès l'accès à la BDD) et le nombre de like et RT affiché à côté.
Le goat (tweet) affiche également le pseudo @ de l'utilisateur ainsi qu'un lien vers son profil.

L'image à droite du menu permet un accès rapide à la page de modification du profil ainsi que la déconnexion (ajout d'une nouvelle méthode)
Cette image est affichée seulement
si un utilisateur est connecté.

L'index permet l'affichage de tous les derniers goat (tweet). Il est accessible seulement lorsque l'utilisateur est connecté. Il affiche
également les comptes inscrit sur le site

Le login est l'inscription sont dans l'action login

La redirection est entrain d'être implementer. Pour le moment seul la page view_profile est concerné. Il faut aller sur cette page sans être
connecté : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=view_profile&id=1
On sera rediriger vers https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=login&redirect=view_profile&id=1
Et dès l'entrée des ID et password on retombe sur https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=view_profile&id=1


TP6 : Les tests de toutes les classes sont à l'adresse suivante : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=test