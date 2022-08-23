<?php
session_start();
?>

<?php
if (isset($_SESSION['login'])) {
?>

    <!-- Bouton du menu -->
    <?php
    require_once('fonction.php');
    menu_medecin();
    ?>

    <?php

    $linkpdo = connection();

    //Préparation de la requête
    $pdoStat = $linkpdo->prepare('UPDATE medecin set civilite=:civilite, nom=:nom, prenom=:prenom WHERE id_medecin=:id_medecin LIMIT 1');

    //Liaison du paramètre nommé
    $pdoStat->bindValue(':id_medecin', $_POST['id'], PDO::PARAM_INT);

    $pdoStat->bindValue(':civilite', $_POST['genre'], PDO::PARAM_STR_CHAR);

    $pdoStat->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);

    $pdoStat->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);

    //éxécuter la requête
    $execute = $pdoStat->execute();

    if ($execute) {
        $message = "Le médecin à été mis à jour";
    } else {
        $message = "Echec de la mise à jour du médecin";
    }
    ?>

    <!doctype html>
    <html lang="fr">

    <head>
        <meta chatset="UTF-8">
        <meta name="viewport" content="width-device-width, user-scalable-no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">

        <title>Contact Modifié !</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/monStyle.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center ">
                    <legend>Résultat de la modification</legend>
                    <p><?= $message ?></p>

                    <br>
                    <br>
                    <form action="medecin.php" method="post">
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