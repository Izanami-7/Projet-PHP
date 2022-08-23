<?php
session_start();
?>

<?php
if (isset($_SESSION['login'])) {
?>

    <html>

    <head>
        <title>Cabinet Médical</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/monStyle.css" rel="stylesheet">
    </head>

    <body>
        <!-- Bouton du menu -->
        <?php
        require_once('fonction.php');
        menu_medecin();
        ?>

        <div class="container">
            <div class="row">
                <div class="col-sm-6 bordure">
                    <!-- Forumulaire pour inscrire un nouvel usager -->
                    <form action="ajouter_medecin.php" method="post">
                        <fieldset>
                            <legend>Ajouter un nouveau médecin</legend>

                            <p>Civilité : <input type="radio" name="genre" value="F" required>F
                                <input type="radio" name="genre" value="H" required>H
                            </p>
                            <p>Nom : <input type="text" name="nom" required /></p>
                            <p>Prenom : <input type="text" name="prenom" required /></p>
                            <input type="submit" value="Ajouter">
                            <input type="reset">
                        </fieldset>
                    </form>
                </div>

                <div class="col-sm-6 bordure">

                    <form action="medecin_rech.php" method="post">
                        <fieldset>
                            <legend>Rechercher un médecin</legend>
                            <p>Nom : <input type="text" name="nomr" required /></p>
                            <p style="padding-top: 5em;">
                            <input type="submit" value="Rechercher">
                            <input type="reset">
                            </p>
                        </fieldset>
                    </form>
                </div>

                <div class="col-sm-12 bordure">

                    <!-- Afficher le tableau de tout les usagers dans la BDD -->
                    <?php
                    setlocale(LC_TIME, 'fr_FR', 'fr');
                    $linkpdo = connection();

                    ///Préparation de la requête
                    //$req->execute(array('nom' => '%'.$vNomR.'%', 'prenom' => '%'.$vPrenomR.'%'));
                    $req = $linkpdo->prepare("SELECT * FROM medecin ORDER BY nom ASC");

                    ///Exécution de la requête
                    $req->execute();

                    ///Mise en page
                    if ($req) {
                        echo "<legend class=\"text-center\">Liste des médecins dans le logiciel<legend>\n";
                        $nbUtilisateur = $req->rowCount();
                        if ($nbUtilisateur > 0) {
                            echo "<table class=\"table table-bordered table-striped text-center\">\n";
                            echo "<tr>\n";
                            echo "<td><strong>Civilitée</strong></td>\n";
                            echo "<td><strong>Nom</strong></td>\n";
                            echo "<td><strong>Prénom</strong></td>\n";
                            echo "<td><strong>Modifier</strong></td>\n";
                            echo "<td><strong>Supprimer</strong></td>\n";
                            echo "</tr>\n";
                            while ($utilisateur = $req->fetch()) {
                                echo "<tr>\n";
                                echo "<td>" . $utilisateur["civilite"] . "</td>\n";
                                echo "<td>" . $utilisateur["nom"] . "</td>\n";
                                echo "<td>" . $utilisateur["prenom"] . "</td>\n";
                                echo "<td><a href='medecin_form_modif.php?id=" . $utilisateur["id_medecin"] . "'>Modifier </a></td>\n";
                                //Lien qui supprime le client avec confirmation
                                echo "<td><a onClick=\"javascript: return confirm('Voulez-vous vraiment supprimer le médecin ?');\" href='supp_medecin.php?id=" . $utilisateur["id_medecin"] . "'>Supprimer</a></td><tr>"; //use double quotes for js inside php!
                                echo "</tr>\n";
                            }
                            echo "</table>\n";
                        } else {
                            echo "Aucun médecin inscrit";
                        }
                    } else {
                        echo "Requête non fonctionnel";
                    }
                    ?>

    </body>

    </html>

<?php
} else {
    echo "<h1>Accès non autorisé </h1>";
?>
    <form action="../index.php" method="post">
        <p> Retourner sur la page de connexion : <input type="submit" value="Retour"> </p>
    </form>
<?php } ?>