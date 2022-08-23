<?php
    session_start();
?>

<?php
    if(isset($_SESSION['login'])) {
?>

<!-- Bouton du menu -->
        <?php
            require_once('fonction.php');
            menu_medecin();    
        ?>

<?php
    
    $linkpdo=connection();

    //on récupère les infos de la table
    $pdoStat = $linkpdo->prepare('SELECT * FROM medecin WHERE id_medecin=:id_medecin');

    //on récupère l'information contenue dans l'url ou le sumbit
    $pdoStat->bindValue(':id_medecin',$_GET['id'],PDO::PARAM_STR_CHAR);

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
    <form action="medecin_modif_end.php" method="post">
    <fieldset>
            <legend>Modifier un médecin :</legend>
            <? if ($val == "oui") echo "selected"; ?>

            <p><input readonly="readonly" type="HIDDEN" name="id" value="<?= $result['id_medecin'] ?>" required /></p>
            <p>Civilité : <input type="radio" name="genre" value="F" <?php if (isset($result["civilite"])) { if ($result["civilite"] == "F") { echo "checked"; } } ?>  required>F  
                            <input type="radio" name="genre" value="H" <?php if (isset($result["civilite"])) { if ($result["civilite"] == "H") { echo "checked"; } } ?> required>H </p>
            <p>Nom : <input type="text" name="nom" value="<?= $result['nom'] ?>" required /></p>
            <p>Prenom : <input type="text" name="prenom" value="<?= $result['prenom'] ?>" required /></p>
            <input type="submit" value="Enregistrer les valeurs">
    </fieldset>
    </form>

    <br>
    <br>
    <form action="medecin.php" method="post">
        <input type="submit" name="retour" value="Retour" />
    </form>
                </div>
</body>
</html>

<?php
    }else{
        echo "<h1>Accès non autorisé </h1>";
        ?>
        <form action="../index.php" method="post">
            <p> Retourner sur la page de connexion : <input type="submit" value="Retour"> </p>
        </form>
    <?php } ?>