<?php
session_start();
?>

<?php
if (isset($_SESSION['login'])) {
?>

    <?php
    require_once('fonction.php');

    $linkpdo = connection();
    ?>

    <html>

    <head>
        <title>Usagers</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/monStyle.css" rel="stylesheet">
    </head>

    <body>


        <?php
        require_once('fonction.php');
        menu_usager();
        ?>

        <div class="container">
            <div class="row">
                <div class="col-sm-6 bordure">

                    <!-- Forumulaire pour inscrire un nouvel usager -->
                    <form action="ajouter_usager.php" method="post">
                        <fieldset>
                            <legend class="text-center">Ajouter un nouvel usager</legend>

                            <p>Civilité : <input type="radio" name="genre" value="F" required>F
                                <input type="radio" name="genre" value="H" required>H
                            </p>
                            <p>Nom : <input type="text" name="nom" required /></p>
                            <p>Prenom : <input type="text" name="prenom" required /></p>
                            <p>Adresse : <input type="text" name="adresse" required /></p>
                            <p>Code Postal : <input type="text" name="code" required /></p>
                            <p>Ville : <input type="text" name="ville" required /></p>
                            <p>Date de naissance : <input type="date" name="date" required /></p>
                            <p>Lieu de naissance : <input type="text" name="lieu" required /></p>
                            <p>N° de sécurité sociale : <input type="text" name="num" required /></p>

                            <p>Médecin référent : <select name="refmed" id="refmed" required> </p>
                            <?php
                            $reponse = $linkpdo->query('select * from medecin ');
                            while ($donnees = $reponse->fetch()) {
                            ?>
                                <option value="<?php echo $donnees['id_medecin']; ?>">
                                    <?php echo "Dr. ";
                                    echo $donnees['nom']; ?>
                                </option>
                            <?php } ?>
                            </select>

                            <p style="padding-top: 1em;">
                                <input type="submit" value="Ajouter">
                                <input type="reset">
                            </p>
                        </fieldset>
                    </form>
                </div>

                <div class="col-sm-6 bordure">
                    <form action="usager_rech.php" method="post">
                        <fieldset>
                            <legend class="text-center">Rechercher un usager</legend>
                            <p>Nom : <input type="text" name="nomr" required /></p>
                            <p>Prenom : <input type="text" name="prenomr" required /></p>

                            <p style="padding-top: 23em;">
                                <input type="submit" value="Rechercher">
                                <input type="reset">
                            </p>
                        </fieldset>
                    </form>
                </div>

                <div class="col-sm-12 bordure">
                    <!-- Afficher le tableau de tout les usagers dans la BDD -->
                    <?php

                    $linkpdo = connection();


                    ///Préparation de la requête
                    //$req->execute(array('nom' => '%'.$vNomR.'%', 'prenom' => '%'.$vPrenomR.'%'));
                    $req = $linkpdo->prepare("SELECT *, medecin.nom AS nomM, DATE_FORMAT(date_n, '%d/%m/%Y') AS date,
                                        patient.nom AS nomP, patient.prenom AS preP, patient.civilite AS civilP 
                                    FROM patient, medecin
                                    WHERE patient.id_medecin = medecin.id_medecin
                                    ORDER BY patient.nom ASC");

                    ///Exécution de la requête
                    $req->execute();

                    ///Mise en page
                    if ($req) {
                        echo "<legend class=\"text-center\">Liste des usagers dans logiciel<legend>\n";
                        $nbUtilisateur = $req->rowCount();
                        if ($nbUtilisateur > 0) {
                            echo "<table class=\"table table-bordered table-striped text-center\">\n";
                            echo "<tr>\n";
                            echo "<td><strong>Civilitée</strong></td>\n";
                            echo "<td><strong>Nom</strong></td>\n";
                            echo "<td><strong>Prénom</strong></td>\n";
                            echo "<td><strong>Adresse</strong></td>\n";
                            echo "<td><strong>Code Postal</strong></td>\n";
                            echo "<td><strong>Ville</strong></td>\n";
                            echo "<td><strong>Date de naissance</strong></td>\n";
                            echo "<td><strong>Lieu de naissance</strong></td>\n";
                            echo "<td><strong>N° sécurité social</strong></td>\n";
                            echo "<td><strong>Médecin référent</strong></td>\n";
                            echo "<td><strong>Modifier</strong></td>\n";
                            echo "<td><strong>Supprimer</strong></td>\n";
                            echo "</tr>\n";
                            while ($utilisateur = $req->fetch()) {
                                echo "<tr>\n";
                                echo "<td>" . $utilisateur["civilP"] . "</td>\n";
                                echo "<td>" . $utilisateur["nomP"] . "</td>\n";
                                echo "<td>" . $utilisateur["preP"] . "</td>\n";
                                echo "<td>" . $utilisateur["adresse"] . "</td>\n";
                                echo "<td>" . $utilisateur["code"] . "</td>\n";
                                echo "<td>" . $utilisateur["ville"] . "</td>\n";
                                echo "<td>" . $utilisateur["date"] . "</td>\n";
                                echo "<td>" . $utilisateur["lieux_n"] . "</td>\n";
                                echo "<td>" . $utilisateur["num_secu"] . "</td>\n";
                                echo "<td>Dr. " . $utilisateur["nomM"] . "</td>\n";
                                echo "<td><a href='usager_form_modif.php?id=" . $utilisateur["id_patient"] . "'>Modifier </a></td>\n";
                                //Lien qui supprime le client avec confirmation
                                echo "<td><a onClick=\"javascript: return confirm('Voulez-vous vraiment supprimer l\'usager ?');\" href='supp_usager.php?id=" . $utilisateur["id_patient"] . "'>Supprimer</a></td><tr>"; //use double quotes for js inside php!
                                echo "</tr>\n";
                            }
                            echo "</table>\n";
                        } else {
                            echo "Aucun usager dans la liste";
                        }
                    } else {
                        echo "Requête non fonctionnel";
                    }
                    ?>
                </div>

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