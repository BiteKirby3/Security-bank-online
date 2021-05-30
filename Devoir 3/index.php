<?php
  require_once('config/config.php');
  require_once('include.php');

  // test connection mySQL
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
  
  if ($mysqli->connect_error) {
        // probleme connection mySQL =>STOP
        echo '<html><head><meta charset="utf-8"><title>MySQL Error</title><link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" /></head><body>'.
             '<p>Impossible de se connecter a MySQL.</p>'.
             '<p>Voici le message d\'erreur : <b>'. utf8_encode($mysqli->connect_error) . '</b></p>'.
             '<br/>Verifiez vos parametres dans le config.ini'.
             '</body></html>';        
  } else {
        // mySQL r��pond bien
        session_start();

        if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
            // utilisateur non connect��
            header('Location: vw_login.php');      

        } else {
            header('Location: vw_accueil.php');      
        }
  }

?>
