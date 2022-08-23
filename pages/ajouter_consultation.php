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
    $pdoStat = $linkpdo->prepare('INSERT INTO consultation VALUES (NULL, :date_rdv, :heure_rdv, :duree, :id_medecin, :id_patient)');

    //Liaison du paramètre nommé
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

    //Vérification si la consultation n'est pas à la même heure du même medecin
    $req = $linkpdo->prepare("SELECT *, DATE_FORMAT(consultation.date_rdv, '%d/%m/%Y') AS dateV, DATE_FORMAT(consultation.heure_rdv, '%H : %i') AS heureV,
                            medecin.nom AS nomM 
                            FROM consultation, medecin
                            WHERE consultation.id_medecin LIKE :id_medecin AND consultation.date_rdv LIKE :date_rdv 
                            AND consultation.heure_rdv LIKE :heure_rdv
                            AND consultation.id_medecin = medecin.id_medecin");

    $req->execute(array('id_medecin' => '%' . $_POST['sltmed'] . '%', 'date_rdv' => '%' . $date . '%', 'heure_rdv' => '%' . $temps . '%'));
    $nbReq = $req->rowCount();

    //éxécuter la requête
    if ($nbReq > 0) {
        $execute = NULL;
    } else {
        $execute = $pdoStat->execute();
    }


    if ($execute) {
        $message = "La consultation à été ajouté";
    } else {
        $message = "Echec de l'ajout de la consultation dans la liste";
    }
    ?>

    <!doctype html>
    <html lang="fr">

    <head>
        <meta chatset="UTF-8">
        <meta name="viewport" content="width-device-width, user-scalable-no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">

        <title>Cabinet Médical</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/monStyle.css" rel="stylesheet">
    </head>

    <body>

    <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
        <legend>Résultat de l'ajout :</legend>
        <p><?= $message ?></p>

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