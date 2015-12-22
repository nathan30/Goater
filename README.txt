CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/

TP6 : Les tests de toutes les classes sont à l'adresse suivante : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=test
Ajout de la méthode getUserByPseudo($pseudo) afin de faire la view_profile avec le pseudo plutot que l'id
La modification du profil se fait avec l'action edit=true
Ajout de la suppression du tweet. Ajout dans le controller de delete_tweet et de la fonction deleteTweetById($id) dans TweetTable, qui utilise
getTweetById($id)