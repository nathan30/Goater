CHEVAL NATHAN
DESPRET JEAN-PHILIPPE

URL : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/

TP6 : Les tests de toutes les classes sont à l'adresse suivante : https://pedago02a.univ-avignon.fr/~uapv1402577/mvc/goater.php?action=test
Ajout de la méthode getUserByPseudo($pseudo) afin de faire la view_profile avec le pseudo plutot que l'id
La modification du profil se fait avec l'action edit=true
Ajout de la suppression du tweet. Ajout dans le controller de delete_tweet et de la fonction deleteTweetById($id) dans TweetTable, qui utilise
getTweetById($id). La fonction supprime le tweet ainsi que le post associé
Les images sont gérées et affichées. A cause du problème des urls des images, si une image est présente mais non accessible une chèvre est 
affichée
Ajout de la fonction share_tweet pour afficher seulement un tweet et le partager
Ajout de la fonction search afin de chercher des tweets via un mot clés (ajout de la fonction getPostByHashTag($hashtag) 
et getTweetsByPostId($id) )
Ajout de la fonction RT avec la fonction rtTweetById($id)
Ajout de la fonction like avec addVotebyId($id)


TP7 : 
L'AJAX gère désormais l'envoie de tweet, la suppression de tweet, l'ajout de la suppression de vote pour un tweet et la modification de profil
Toutes les fonctions propres à l'AJAX sont à la fin du mainController.php
Toutes la partie AJAX est dans js/script.js