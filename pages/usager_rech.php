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
        menu_usager();
        ?>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $vNomR = $_POST['nomr'];
                    $vPrenomR = $_POST['prenomr'];

                    $linkpdo = connection();

                    ///Préparation de la requête
                    $req = $linkpdo->prepare("SELECT *, medecin.nom AS nomM, DATE_FORMAT(date_n, '%d/%m/%Y') AS date,
                            patient.nom AS nomP, patient.prenom AS preP, patient.civilite AS civilP
                            FROM patient, medecin
                            WHERE patient.nom LIKE :nom AND patient.prenom LIKE :prenom AND patient.id_medecin = medecin.id_medecin");

                    ///Exécution de la requête
                    $req->execute(array('nom' => '%' . $vNomR . '%', 'prenom' => '%' . $vPrenomR . '%'));

                    ///Mise en page
                    if ($req) {
                        echo "<legend class=\"text-center\">Usager(s) trouvé(s) :</legend>\n";
                        $nbUtilisateur = $req->rowCount();
                        if ($nbUtilisateur > 0) {
                            echo "<tableclass=\"table table-bordered table-striped text-center\">\n";
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
                                echo "<td><a href='supp_usager.php?id=" . $utilisateur["id_patient"] . "'>Supprimer </a></td>\n";
                                echo "</tr>\n";
                            }
                            echo "</table>\n";
                        } else {
                            echo "Aucune personne trouvée";
                        }
                    } else {
                        echo "Requête non fonctionnel";
                    }
                    ?>

                    <br>
                    <br>
                    <form class="text-center" action="usager.php" method="post">
                        <input type="submit" name="retour" value="Retour" />
                    </form>
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