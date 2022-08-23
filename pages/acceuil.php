<!doctype html>
<?php
session_start();
?>

<?php
if (isset($_POST['login'])) {
  $user = $_POST['login'];
  $pass = $_POST['mdp'];

  if ($user == "Steven" && $pass == "123") {
    $_SESSION['login'] = $user;
  } else {
    header('Location: error.php');
  }
}

if (isset($_POST['deco'])) {
  session_destroy();
  header("location:index.php");
}

if (isset($_SESSION['login'])) {
?>

  <html>

  <head>
    <title>Bienvenue <?php echo $_SESSION['login'] ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/monStyle.css" rel="stylesheet">
  </head>

  <body>

    <?php
    require_once('fonction.php');
    menu();
    ?>


    <div>
      <h2 class="text-center"> Bienvenue, <?php echo $_SESSION['login']; ?> !</h2>

      <div class="container">
        <div class="row">
          <div class="col-sm-6 bordure">

            <!-- Forumulaire pour inscrire un nouvel usager -->
            <form action="ajouter_consultation.php" method="post">
              <fieldset>
                <legend class="text-center">Ajouter une nouvelle consultation</legend>


                <?php
                require_once('fonction.php');
                $linkpdo = connection();
                ?>

                <p>Médecin : <select name="sltmed" id="sltmed" required> </p>
                <?php
                $reponse = $linkpdo->query('select * from medecin ');
                while ($donnees = $reponse->fetch()) {
                ?>
                  <option value="<?php echo $donnees['id_medecin']; ?>">
                    <?php echo "Dr. ";
                    echo $donnees['nom']; ?>
                  </option>
                <?php } ?>
                </select>

                <p>Patient : <select name="sltpat" id="sltpat" required> </p>
                <?php
                $reponse = $linkpdo->query('select * from patient ');
                while ($donnees = $reponse->fetch()) {
                ?>
                  <option value="<?php echo $donnees['id_patient']; ?>">
                    <?php echo $donnees['nom']; ?>
                  </option>
                <?php } ?>
                </select>

                <p>Date de la consultation : <input type="date" name="date" required /></p>

                <p>Heure de la consultation : <input type="time" name="temps" required /></p>

                <p>Durée de la consultation : <input type="number" name="duree" value="30" required /> min.</p>
                
                <input type="submit" value="Ajouter">
                <input type="reset">
              </fieldset>
            </form>
          </div>

          <div class="col-sm-6 bordure">
            <form action="consultation_rech.php" method="post">
              <fieldset>
                <legend class="text-center">Rechercher une consultation</legend>
                <p>Patient : <select name="sltpatr" id="sltpatr" required> </p>
                <?php
                $reponse = $linkpdo->query('select * from patient ');
                while ($donnees = $reponse->fetch()) {
                ?>
                  <option value="<?php echo $donnees['id_patient']; ?>">
                    <?php echo $donnees['nom']; ?>
                  </option>
                <?php } ?>
                </select>
                <p class="pad_dateConsu">Date de la consultation : <input type="date" name="dater" required /></p>
                <input type="submit" value="Rechercher">
                <input type="reset">
              </fieldset>
            </form>
          </div>

          <div class="col-sm-12 bordure">
            <!-- Afficher le tableau de tout les usagers dans la BDD -->

            <legend class="text-center" style="padding-top: 1em;">Liste des consultations prévues </legend>
            <?php
            setlocale(LC_TIME, 'fr_FR', 'fr');

            // $servname = 'localhost';
            // $dbname = 'cabinet';
            // $user = 'root';
            // $pass = '';

            // ///Connexion au serveur MySQL
            // try {
            //   $linkpdo = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
            //   $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // } catch (Exception $e) {
            //   die('Erreur : ' . $e->getMessage());
            // }

            ///Préparation de la requête
            $req = $linkpdo->prepare("SELECT *, DATE_FORMAT(consultation.date_rdv, '%d/%m/%Y') AS dateV, DATE_FORMAT(consultation.heure_rdv, '%H : %i') AS heureV,
                                    medecin.nom AS nomM, patient.nom AS nomP
                                    FROM consultation, medecin, patient 
                                    WHERE consultation.id_medecin = medecin.id_medecin AND consultation.id_patient = patient.id_patient
                                    ORDER BY date_rdv ASC");

            ///Exécution de la requête
            $req->execute();

            ///Mise en page
            if ($req) {
              $nbUtilisateur = $req->rowCount();
              if ($nbUtilisateur > 0) {
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
                while ($utilisateur = $req->fetch()) {
                  echo "<tr>\n";
                  echo "<td>" . $utilisateur["dateV"] . "</td>\n";
                  echo "<td>" . $utilisateur["heureV"] . "</td>\n";
                  echo "<td>" . $utilisateur["duree"] . "</td>\n";
                  echo "<td>Dr. " . $utilisateur["nomM"] . "</td>\n";
                  echo "<td>" . $utilisateur["nomP"] . "</td>\n";
                  echo "<td><a href='consultation_form_modif.php?id=" . $utilisateur["id_consult"] . "'>Modifier </a></td>\n";
                  //Lien qui supprime le client avec confirmation
                  echo "<td><a onClick=\"javascript: return confirm('Voulez-vous vraiment supprimer la consultation ?');\" href='supp_consultation.php?id=" . $utilisateur["id_consult"] . "'>Supprimer</a></td><tr>"; //use double quotes for js inside php!
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
          </div>

  </body>

  </html>

<?php
} else {
  echo "<h1>Accès non autorisée </h1>";
?>
  <form action="../index.php" method="post">
    <p> Retourner sur la page de connection : <input type="submit" value="Retour"> </p>
  </form>
<?php } ?>