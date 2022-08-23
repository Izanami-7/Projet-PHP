<!doctype html>
<?php
// Démarer la session
session_start();
session_destroy();
?>

<html lang="fr">

<head>
  <title>Connexion</title>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/monStyle.css" rel="stylesheet">

  <nav class="navbar-header">

  </nav>
</head>

<body class="text-center" id="index">

  <main class="form-signin">

    <form class="needs-validation" action="pages/acceuil.php" method="post">
      <img class="mb-4" src="img/logo_login.png" width="300" height="225">
      <h1 class="h3 mb-3 fw-normal">Connectez-vous </h1>

      <div class="form-floating">
        <input name="login" type="text" class="form-control" placeholder="NomUti" required>
        <label for="floatingInput " class="form-label">Nom d'utilisateur</label>

      </div>

      <div class="form-floating">
        <input name="mdp" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Mot de Passe</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Connexion</button>

    </form>
  </main>
</body>

</html>