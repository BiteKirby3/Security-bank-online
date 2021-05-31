<?php
require_once('include.php');
session_start();
$url_redirect = "index.php";
if (!isset($_SESSION["connected_user"])) {
  // utilisateur non connecte
  header('Location: vw_login.php');
  exit();
} else if ($_SESSION['profil'] != "EMPLOYE") {
  header('HTTP/1.0 403 Forbidden');
  die("Désolé, vous n'avez pas le droit de consulter cette page !");
}

?>


<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Liste de Clients</title>
  <link rel="stylesheet" type="text/css" media="all" href="css/mystyle.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
  <header>
    <form method="POST" action="myController.php">
      <input type="hidden" name="action" value="retour">
      <button class="btn-logout form-btn btn btn-secondary" style="margin-right:50px;">Retour</button>
    </form>
    <h2 style="text-align:center; margin-top:30px;">Liste de Clients</h2>
  </header>
  <br><br>

  <section>
    <article>
      <div class="liste">

        <table>
          <tr>
            <th style="background-color:#28a745;">ID Client</th>
            <th style="background-color:#28a745;">Nom</th>
            <th style="background-color:#28a745;">Prenom</th>
            <th style="background-color:#28a745;">Numero Compte</th>
            <th style="background-color:#28a745;">Gestion</th>
          </tr>
          <?php
          foreach ($_SESSION['listeClients'] as $user) {
            echo '<tr>';
            echo '<td>' . $user['id_user'] . '</td>';
            echo '<td>' . $user['nom'] . '</td>';
            echo '<td>' . $user['prenom'] . '</td>';
            echo '<td>' . $user['numero_compte'] . '</td>';
            echo '<td><form method="POST" action="myController.php" >';
            echo '<input type="hidden" name="action" value="gestion">';
            echo '<input type="hidden" name="login" value="' . $user['login'] . '">';
            echo '<button class="form-btn">Gestion de compte du client</button>';
            echo '</form></td>';
            echo '</tr>';
          }
          ?>
        </table>
      </div>

    </article>
  </section>
</body>

</html>