CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/

index.php dans /inscription est utilis� seulement pour l'inscription

Le login est effectu� gr�ce � la m�thode login

Dans la vue du profil, la gestion des avatar (ajout d'un avatar par d�faut si pas d'avatar sur le profil) sera ajout� d�s l'acc�s � la BDD

La liste est pour le moment statique, et am�ne � la view_profile avec un param�tre suppl�mentaire "id". Cette ID permet seulement, pour le moment,
de d�finir si le profil est vu par l'utilisateur logu� ou pas. L'input servant de modification du statut est affich� ou pas. Le pseudo est 
�galement rajout� dans le formulaire du tweet si c'est le profil d'un autre utilisateur

La template Tweet est impl�ment� dans view_profile avec un include. La gestion de l'affichage (si utilisateur logu� etc..) sera g�r� d�s
l'acc�s � la BDD. Un bouton like et RT sont cliquable (et en fonction d�s l'acc�s � la BDD) et le nombre de like et RT affich� � c�t�.
Le goat (tweet) affiche �galement le pseudo @ de l'utilisateur ainsi qu'un lien vers son profil.

L'image � droite du menu permet un acc�s rapide � la page de modification du profil ainsi que la d�connexion (ajout d'une nouvelle m�thode)
Cette image est affich�e seulement
si un utilisateur est connect�.

L'index permet l'affichage de tous les derniers goat (tweet). Il est accessible seulement lorsque l'utilisateur est connect�. Il affiche
�galement les comptes inscrit sur le site

Le login est l'inscription sont dans l'action login

La redirection est entrain d'�tre implementer. Pour le moment seul la page view_profile est concern�. Il faut aller sur cette page sans �tre
connect� : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=view_profile&id=1
On sera rediriger vers https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=login&redirect=view_profile&id=1
Et d�s l'entr�e des ID et password on retombe sur https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=view_profile&id=1


TP6 : Les tests de toutes les classes sont � l'adresse suivante : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=test