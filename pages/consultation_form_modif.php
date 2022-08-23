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

    //on récupère les infos de la table
    $pdoStat = $linkpdo->prepare('SELECT * FROM consultation WHERE id_consult=:id_consult');

    //on récupère l'information contenue dans l'url ou le sumbit
    $pdoStat->bindValue(':id_consult', $_GET['id'], PDO::PARAM_STR);

    //exécuter la requête
    $execute = $pdoStat->execute();

    //récupérer le résultat
    $result = $pdoStat->fetch();

    ?>

    <!doctype html>
    <html lang="fr">

    <head>
        <meta chatset="UTF-8">
        <meta name="viewport" content="width-device-width, user-scalable-no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">

        <title>Modification</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/monStyle.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center table">
                    <form action="consultation_modif_end.php" method="post">
                        <fieldset>
                            <legend>Modifier la consultaion :</legend>

                            <p><input readonly="readonly" type="HIDDEN" name="id" value="<?= $result['id_consult'] ?>" required /></p>

                            <p>Médecin : <select name="sltmed" id="sltmed" required> </p>
                            <?php
                            $reponse = $linkpdo->query('select * from medecin ');
                            while ($donnees = $reponse->fetch()) {
                                if ($donnees["id_medecin"] == $result["id_medecin"]) {
                                    echo "<option value='" . $donnees["id_medecin"] . "' selected> Dr. " . $donnees["nom"] . "</option>";
                                } else {
                                    echo "<option value='" . $donnees["id_medecin"] . "'> Dr. " . $donnees["nom"] . "</option>";
                                }
                            } ?>
                            </select>


                            <p>Patient : <select name="sltpat" id="sltpat" required> </p>
                            <?php
                            $reponse = $linkpdo->query('select * from patient ');
                            while ($donnees = $reponse->fetch()) {
                                if ($donnees["id_patient"] == $result["id_patient"]) {
                                    echo "<option value='" . $donnees["id_patient"] . "' selected>" . $donnees["nom"] . "</option>";
                                } else {
                                    echo "<option value='" . $donnees["id_patient"] . "'>" . $donnees["nom"] . "</option>";
                                }
                            } ?>
                            </select>

                            <p>Date de la consultation : <input type="date" name="date" value="<?= $result['date_rdv'] ?>" required /></p>
                            <p>Heure de la consultation : <input type="time" name="temps" value="<?= $result['heure_rdv'] ?>" required /></p>
                            <p>Durée de la consultation : <input type="number" name="duree" value="<?= $result['duree'] ?>" required /> min.</p>
                            <input type="submit" value="Enregistrer les valeurs">
                        </fieldset>
                    </form>

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