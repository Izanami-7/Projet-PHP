
<?php
    session_start();
?>

<?php
    if(isset($_SESSION['login'])) {
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
            menu();    
        ?>

<div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">

<?php
    $vPat = $_POST['sltpatr'];
    $vDate = $_POST['dater'];

    $linkpdo=connection();
                
    ///Préparation de la requête
    $req = $linkpdo->prepare("SELECT *, DATE_FORMAT(consultation.date_rdv, '%d/%m/%Y') AS dateV, DATE_FORMAT(consultation.heure_rdv, '%H : %i') AS heureV,
                            medecin.nom AS nomM, patient.nom AS nomP 
                            FROM consultation, patient, medecin
                            WHERE consultation.id_patient LIKE :id_patient AND consultation.date_rdv LIKE :date_rdv 
                            AND consultation.id_medecin = medecin.id_medecin AND consultation.id_patient = patient.id_patient");

    ///Exécution de la requête
    $req->execute(array('id_patient' => '%'.$vPat.'%', 'date_rdv' => '%'.$vDate.'%'));
    
    ///Mise en page
    if($req) {
        echo "<legend class=\"text-center\">Liste des consultations prévues</legend>\n";
        $nbUtilisateur = $req->rowCount();
        if($nbUtilisateur > 0) {
            echo "<table class=\"table table-bordered table-striped text-center\">\n";
            echo "<tr>\n";
            echo "<td><strong>Date du RDV</strong></td>\n";
            echo "<td><strong>Heure du RDV</strong></td>\n";
            echo "<td><strong>Durée</strong></td>\n";
            echo "<td><strong>Nom du médecin</strong></td>\n";
            echo "<td><strong>Nom du patient</strong></td>\n";
            echo "<td><strong>Modifier</strong></td>\n";
            echo "<td><strong>Supprimer</strong></td>\n";
            echo "</tr>\n";
            while($utilisateur = $req->fetch()) {
                echo "<tr>\n";
                echo "<td>" . $utilisateur["dateV"] . "</td>\n";
                echo "<td>" . $utilisateur["heureV"] . "</td>\n";
                echo "<td>" . $utilisateur["duree"] . "</td>\n";
                echo "<td>Dr. " . $utilisateur["nomM"] . "</td>\n";
                echo "<td>" . $utilisateur["nomP"] . "</td>\n";
                echo "<td><a href='consultation_form_modif.php?id=". $utilisateur["id_consult"] ."'>Modifier </a></td>\n";
                //Lien qui supprime le client avec confirmation
                echo "<td><a onClick=\"javascript: return confirm('Voulez-vous vraiment supprimer la consultation ?');\" href='supp_consultation.php?id=".$utilisateur["id_consult"]."'>Supprimer</a></td><tr>"; //use double quotes for js inside php!
                echo "</tr>\n";
            }
            echo "</table>\n";
        } else {
            echo "Aucune consultation enregistrée";
        }
    } else {
        echo "Requête non fonctionnel";
    }
?>

    <br>
    <br>
    <form action="acceuil.php" method="post">
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