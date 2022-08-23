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
                <div class="col-sm-12">
                    <?php
                    $vNomR = $_POST['nomr'];

                    $linkpdo = connection();

                    ///Préparation de la requête
                    $req = $linkpdo->prepare("SELECT * FROM medecin WHERE nom LIKE :nom ");

                    ///Exécution de la requête
                    $req->execute(array('nom' => '%' . $vNomR . '%'));

                    ///Mise en page
                    if ($req) {
                        echo "<legend class=\"text-center\">Médecin(s) trouvé(s) :</legend>\n";
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
                                echo "<td><a href='supp_medecin.php?id=" . $utilisateur["id_medecin"] . "'>Supprimer </a></td>\n";
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
                    <form class="text-center" action="medecin.php" method="post">
                        <input type="submit" name="retour" value="Retour" />
                    </form>
                </div>
            </div>
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