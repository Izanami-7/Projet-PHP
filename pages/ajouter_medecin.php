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
    $pdoStat = $linkpdo->prepare('INSERT INTO medecin VALUES (NULL, :civilite, :nom, :prenom)');

    //Liaison du paramètre nommé
    $pdoStat->bindValue(':civilite', $_POST['genre'], PDO::PARAM_STR_CHAR);

    $pdoStat->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);

    $pdoStat->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);

    //éxécuter la requête
    $execute = $pdoStat->execute();
    //echo "date:".$_POST['date_consultation'];
    //echo $pdoStat->debugDumpParams();

    if ($execute) {
        $message = "Le médecin à été ajouté";
    } else {
        $message = "Echec de l'ajout du médecin à la liste";
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
                    <form action="medecin.php" method="post">
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