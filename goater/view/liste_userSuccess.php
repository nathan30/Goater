<body>
    <table align="center" border="1" cellpadding="0" cellspacing="0" width="98%">
        <thead><th>Avatar</th><th>Nom</th><th>Prénom</th><th>Identifiant</th></thead>
        <tbody>
            <?php
                $liste_user = utilisateurTable::getUsers();
                foreach($liste_user as $user){
                    $nom = $user->nom;
                    $prenom = $user->prenom;
                    $identifiant= $user->identifiant;
                    $avatar = $user->avatar;
                    echo"<tr>";
                    echo "<td>".$avatar."</td><td>".$nom."</td><td>".$prenom."</td><td>".$identifiant."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
