<?php
function connection()
{
  try {
    $pdo = new PDO("mysql:host=localhost;dbname=cabinet", 'root', '');
    return $pdo;
  } catch (Exception $e) {
    die('Erreur :' . $e->getMessage());
  }
}
?>

<?php
function menu()
{
?>
  <header>
    <div class="container-fluid headcolor navbar-expand-lg">
      <a href="acceuil.php">
        <img src="../img/logo_login" href id="logohead" width="100" height="75">
      </a>

      <h4 class="text-center"><em><a href="acceuil.php" style="color: black;
                                                                  text-decoration: none">
            Cabinet IUT Paul Sabatier</a></em></h4>

      <form action="../index.php" method="post">
        <input class="headcolor" type="submit" name="deco" value="Déconnexion" />
      </form>

      <div class="pad">
        <ul class="nav nav-pills nav-justified ">
          <li class="nav-item" id="active">
            <a class="nav-link" href="#">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="usager.php">Usagers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="medecin.php">Médecins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stats.php">Statistique</a>
          </li>
        </ul>
      </div>
    </div>
  </header>
<?php
}
?>

<?php
function menu_usager()
{
?>
  <header>
    <div class="container-fluid headcolor navbar-expand-lg">
      <a href="acceuil.php">
        <img src="../img/logo_login" href id="logohead" width="100" height="75">
      </a>
      <h4 class="text-center"><em><a href="acceuil.php" style="color: black;
                                                                  text-decoration: none">
            Cabinet IUT Paul Sabatier</a></em></h4>

      <form action="../index.php" method="post">
        <input class="headcolor" type="submit" name="deco" value="Déconnexion" />
      </form>

      <div class="pad">
        <ul class="nav nav-pills nav-justified ">
          <li class="nav-item">
            <a class="nav-link " href="acceuil.php">Accueil</a>
          </li>
          <li class="nav-item" id="active">
            <a class="nav-link" href="#">Usagers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="medecin.php">Médecins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="stats.php">Statistique</a>
          </li>
        </ul>
      </div>
    </div>
  </header> <?php
          }
            ?>


<?php
function menu_medecin()
{
?>
  <header>
    <div class="container-fluid headcolor navbar-expand-lg">
      <a href="acceuil.php">
        <img src="../img/logo_login" href id="logohead" width="100" height="75">
      </a>
      <h4 class="text-center"><em><a href="acceuil.php" style="color: black;
                                                                  text-decoration: none">
            Cabinet IUT Paul Sabatier</a></em></h4>

      <form action="../index.php" method="post">
        <input class="headcolor" type="submit" name="deco" value="Déconnexion" />
      </form>

      <div class="pad">
        <ul class="nav nav-pills nav-justified ">
          <li class="nav-item">
            <a class="nav-link" href="acceuil.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="usager.php">Usagers</a>
          </li>
          <li class="nav-item" id="active">
            <a class="nav-link" href="#">Médecins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stats.php">Statistique</a>
          </li>
        </ul>
      </div>
    </div>
  </header> <?php
          }
            ?>

<?php
function menu_stat()
{
?>
  <header>
    <div class="container-fluid headcolor navbar-expand-lg">
      <a href="acceuil.php">
        <img src="../img/logo_login" href id="logohead" width="100" height="75">
      </a>
      <h4 class="text-center"><em><a href="acceuil.php" style="color: black;
                                                                  text-decoration: none">
            Cabinet IUT Paul Sabatier</a></em></h4>

      <form action="../index.php" method="post">
        <input class="headcolor" type="submit" name="deco" value="Déconnexion" />
      </form>

      <div class="pad">
        <ul class="nav nav-pills nav-justified ">
          <li class="nav-item">
            <a class="nav-link" href="acceuil.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="usager.php">Usagers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="medecin.php">Médecins</a>
          </li>
          <li class="nav-item" id="active">
            <a class="nav-link" href="#">Statistique</a>
          </li>
        </ul>
      </div>
    </div>
  </header> <?php
          }
            ?>