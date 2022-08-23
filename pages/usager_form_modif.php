<?php
    session_start();
?>

<?php
    if(isset($_SESSION['login'])) {
?>

<!-- Bouton du menu -->
        <?php
            require_once('fonction.php');
            menu_usager();    
        ?>

<?php
    
    $linkpdo=connection();

    //on récupère les infos de la table
    $pdoStat = $linkpdo->prepare('SELECT * FROM patient WHERE id_patient=:id_patient');

    //on récupère l'information contenue dans l'url ou le sumbit
    $pdoStat->bindValue(':id_patient',$_GET['id'],PDO::PARAM_STR);

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
    <form action="usager_modif_end.php" method="post">
    <fieldset>
            <legend>Modifier un usager :</legend>

            <p><input readonly="readonly" type="HIDDEN" name="id" value="<?= $result['id_patient'] ?>" required /></p>
            <p>Civilité : <input type="radio" name="genre" value="F" <?php if (isset($result["civilite"])) { if ($result["civilite"] == "F") { echo "checked"; } } ?> required>F 
                            <input type="radio" name="genre" value="H" <?php if (isset($result["civilite"])) { if ($result["civilite"] == "H") { echo "checked"; } } ?> required>H </p>
            <p>Nom : <input type="text" name="nom" value="<?= $result['nom'] ?>" required /></p>
            <p>Prenom : <input type="text" name="prenom" value="<?= $result['prenom'] ?>" required /></p>
            <p>Adresse : <input type="text" name="adresse" value="<?= $result['adresse'] ?>" required /></p>
            <p>Code Postal : <input type="text" name="code" value="<?= $result['code'] ?>" required/></p>
            <p>Ville : <input type="text" name="ville" value="<?= $result['ville'] ?>" required/></p>
            <p>Date de naissance : <input type="date" name="datee" value="<?= $result['date_n'] ?>" required/></p>
            <p>Lieu de naissance : <input type="text" name="lieu" value="<?= $result['lieux_n'] ?>" required/></p>
            <p>N° de sécurité sociale : <input type="text" name="num" value="<?= $result['num_secu'] ?>" required/></p>

            <p>Médecin : <select name="refmed"  id="sltmed" required> </p>
            <?php 
            $reponse = $linkpdo->query('select * from medecin ');
            while ($donnees = $reponse->fetch()) {
			    if($donnees["id_medecin"]==$result["id_medecin"]) {
                    echo "<option value='".$donnees["id_medecin"]."' selected> Dr. ".$donnees["nom"]."</option>";
                }else{
                    echo "<option value='".$donnees["id_medecin"]."'> Dr. ".$donnees["nom"]."</option>";
                }
			 } ?>
		    </select>

            <p><input type="submit" value="Enregistrer les valeurs"></p>
    </fieldset>
    </form>
                

    <br>
    <form action="usager.php" method="post">
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