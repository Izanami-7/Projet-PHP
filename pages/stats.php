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
        menu_stat();
        ?>

        <?php
        setlocale(LC_TIME, 'fr_FR', 'fr');
        $linkpdo = connection();
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <!-- Afficher le tableau de tout les usagers dans la BDD -->
                    <legend class="text-center">Statistique du nombre de patient</legend>
                    <table class="table table-bordered table-striped text-center">

                        <!-- Première ligne -->
                        <tr>
                            <td><strong>Tranche d'âge</strong></td>
                            <td><strong>Nombre d'hommes</strong></td>
                            <td><strong>Nombre de femmes</strong></td>
                        </tr>
                        <!-- Deuxième ligne -->
                        <tr>
                            <td><strong>Moins de 25 ans</strong></td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "H" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 25');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "F" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 25');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                        </tr>
                        <!-- Troisième ligne -->
                        <tr>
                            <td><strong>Entre 25 ans et 50 ans</strong></td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "H" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 25
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 50');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "F" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 25
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)), "%Y")+0)< 50');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                        </tr>
                        <!-- Quatrième ligne -->
                        <tr>
                            <td><strong>Plus de 50 ans</strong></td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "H" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)),"%Y")+0)> 50');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                            <td> <?php
                                    $req = $linkpdo->prepare('SELECT count(*) as nb FROM patient WHERE patient.civilite = "F" 
                                                        AND (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(patient.date_n)),"%Y")+0)> 50');
                                    $req->execute();
                                    $res = $req->fetch();
                                    echo $res['nb'];
                                    ?> </td>
                        </tr>

                    </table>
                </div>

                <div class="col-sm-6">
                <legend class="text-center">Nombre d'heures cumulées des consultations</legend>
                <?php
                $req = $linkpdo->prepare('SELECT SUM(duree) AS dur, medecin.nom AS nomM 
                                                FROM consultation, medecin
                                                WHERE consultation.id_medecin = medecin.id_medecin
                                                GROUP BY nomM');
                $req->execute();

                $nbUtilisateur = $req->rowCount();
                if ($nbUtilisateur > 0) {
                    echo "<table class=\"table table-bordered table-striped text-center\">\n";
                    echo "<tr>\n";
                    echo "<td><strong>Nom du médecin</strong></td>\n";
                    echo "<td><strong>Durée totale des consultations</strong></td>\n";
                    echo "</tr>\n";
                    while ($utilisateur = $req->fetch()) {
                        echo "<tr>\n";
                        echo "<td>Dr. " . $utilisateur["nomM"] . "</td>\n";
                        //Mise en forme pour l'heure, car on a un total en minute
                        $nbtotal = (int) $utilisateur["dur"];
                        $heure = 0;
                        $min = 0;

                        while ($nbtotal > 60) {
                            $heure = $heure + 1;
                            $nbtotal = $nbtotal - 60;
                        }
                        $min = $nbtotal;

                        echo "<td>" . $heure . " h " . $min . " min.</td>\n";
                        echo "</tr>\n";
                    }
                } else {
                    echo "Pas de médecin enregistrée";
                }
                ?>
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