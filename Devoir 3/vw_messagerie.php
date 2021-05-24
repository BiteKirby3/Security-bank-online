<?php
  require_once('include.php');

  session_start();
  
  if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
      // utilisateur non connecté
      header('Location: vw_login.php');      
      exit();
  } 
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Messages</title>
  <link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" />
</head>
<body>
    <header>
        <form method="POST" action="myController.php">
            <button class="btn-back form-btn">Retour</button>
        </form>
        <form method="POST" action="myController.php">
            <input type="hidden" name="action" value="disconnect">
            <button class="btn-logout form-btn">Déconnexion</button>
        </form>
        
        <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Messages reçus</h2>
    </header>

    <section>
        <article>
        
          <div class="liste">
            <table>
              <tr><th>Expéditeur</th><th>Sujet</th><th>Message</th></tr>
              <?php
              foreach ($_SESSION['messagesRecus'] as $cle => $message) {
                echo '<tr>';
                echo '<td>'.$message['nom'].' '.$message['prenom'].'</td>';
                echo '<td>'.htmlentities($message['sujet_msg'], ENT_QUOTES).'</td>';
                echo '<td>'.htmlentities($message['corps_msg'], ENT_QUOTES).'</td>';
                echo '</tr>';
              }
               ?>
            </table>
          </div>
    
        </article>
    </section>
</body>
</html>
