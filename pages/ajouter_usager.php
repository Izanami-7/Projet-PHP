<?php
session_start();
?>

<?php
if (isset($_SESSION['login'])) {
?>

    <!-- Bouton du menu -->
    <?php
    require_once('fonction.php');
    menu_usager();
    ?>

    <?php

    $linkpdo = connection();

    //Préparation de la requête
    $pdoStat = $linkpdo->prepare('INSERT INTO patient VALUES (NULL, :civilite, :nom, :prenom, :adresse, :code, :ville, 
                                                                :date_n, :lieux_n, :num_secu, :id_medecin)');

    //Liaison du paramètre nommé
    $pdoStat->bindValue(':civilite', $_POST['genre'], PDO::PARAM_STR_CHAR);

    $pdoStat->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);

    $pdoStat->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);

    $pdoStat->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);

    $pdoStat->bindValue(':code', $_POST['code'], PDO::PARAM_INT);

    $pdoStat->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);

    //Mise en forme de la date pour être adapter à la base de données
    $date = date('Y-m-d', strtotime($_POST['date']));
    $pdoStat->bindValue(':date_n', $date, PDO::PARAM_STR);
    //$pdoStat->bindValue(':date', $_POST['date'], PDO::PARAM_STR);

    $pdoStat->bindValue(':lieux_n', $_POST['lieu'], PDO::PARAM_STR);

    $pdoStat->bindValue(':num_secu', $_POST['num'], PDO::PARAM_INT);

    $pdoStat->bindValue(':id_medecin', $_POST['refmed'], PDO::PARAM_INT);

    //éxécuter la requête
    $execute = $pdoStat->execute();
    //echo "date:".$_POST['date_consultation'];
    //echo $pdoStat->debugDumpParams();

    if ($execute) {
        $message = "L'usager à été ajouté";
    } else {
        $message = "Echec de l'ajout de l'usager dans la liste";
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
                <div class="col-sm-12">
                    <legend class="text-center">Résultat de l'ajout :</legend>
                    <p class="text-center"><?= $message ?></p>

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