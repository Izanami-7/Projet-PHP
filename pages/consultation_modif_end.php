<?php
session_start();
?>

<?php
if (isset($_SESSION['login'])) {
?>

    <!-- Bouton du menu -->
    <?php
    require_once('fonction.php');
    menu();
    ?>

    <?php

    $linkpdo = connection();

    //Préparation de la requête
    $pdoStat = $linkpdo->prepare('UPDATE consultation set date_rdv=:date_rdv, heure_rdv=:heure_rdv, duree=:duree,
        id_medecin=:id_medecin, id_patient=:id_patient WHERE id_consult=:id_consult LIMIT 1');

    //Liaison du paramètre nommé
    $pdoStat->bindValue(':id_consult', $_POST['id'], PDO::PARAM_STR_CHAR);

    //Mise en forme de la date pour être adapter à la base de données
    $date = date('Y-m-d', strtotime($_POST['date']));
    $pdoStat->bindValue(':date_rdv', $date, PDO::PARAM_STR);

    //Mise en forme du temps
    $temps = date('H:i:s', strtotime($_POST['temps']));
    $pdoStat->bindValue(':heure_rdv', $temps, PDO::PARAM_STR);

    //Valeur par défaut pour la durée
    if ($_POST['duree'] <= 0) {
        $duree = 30;
    } else {
        $duree = $_POST['duree'];
    }
    $pdoStat->bindValue(':duree', $duree, PDO::PARAM_INT);

    $pdoStat->bindValue(':id_medecin', $_POST['sltmed'], PDO::PARAM_INT);

    $pdoStat->bindValue(':id_patient', $_POST['sltpat'], PDO::PARAM_INT);

    //éxécuter la requête
    $execute = $pdoStat->execute();

    if ($execute) {
        $message = "La consultation à été mis à jour";
    } else {
        $message = "Echec de la mise à jour de la consultation";
    }
    ?>

    <!doctype html>
    <html lang="fr">

    <head>
        <meta chatset="UTF-8">
        <meta name="viewport" content="width-device-width, user-scalable-no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">

        <title>Consultation Modifié !</title>
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
                    <form action="acceuil.php" method="post">
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