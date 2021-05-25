<?php
  require_once('include.php');
  
  session_start();
  
  if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
      // utilisateur non connecte
      header('Location: vw_login.php');      
      exit();
  }
  
  $mytoken = bin2hex(random_bytes(128)); // token qui va servir a prevenir des attaques CSRF 
  $_SESSION["mytoken"] = $mytoken;
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Virement</title>
  <link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" />
</head>
<body>
    <header>
        <form method="POST" action="myController.php">
            <input type="hidden" name="action" value="retour">
            <button class="btn-logout form-btn">Retour</button>
        </form>
        
        <h2><?php echo $_SESSION["consult_user"]["prenom"];?> <?php echo $_SESSION["consult_user"]["nom"];?> - Virement</h2>
    </header>
    
    <section>

        
        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Votre compte</span>
              </div>
              <div class="field">
                  <label>No compte : </label><span><?php echo $_SESSION["consult_user"]["numero_compte"];?></span>
              </div>
              <div class="field">
                  <label>Solde : </label><span><?php echo $_SESSION["consult_user"]["solde_compte"];?> &euro;</span>
              </div>
          </div>
        </article>

        <article>
        <form method="POST" action="myController.php">
          <input type="hidden" name="action" value="transfert">
          <input type="hidden" name="mytoken" value="<?php echo $mytoken; ?>">
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Transferer de l'argent</span>
              </div>
              <div class="field">
                  <label>No compte destinataire : </label>
                  <select name="destination">
                    <?php
                    foreach ($_SESSION['listeUsers'] as $id => $user) {
                        if ($id != $_SESSION["consult_user"]["id_user"])
                            echo '<option value="' . $id . '">' . $id . ' ' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
                    }
                    ?>
                    
                  </select>
              </div>
              <div class="field">
                  <label>Montant a transferer : </label><input type="text" size="10" name="montant">
              </div>
              <button class="form-btn">Transferer</button>
              <?php
              if (isset($_REQUEST["err_token"])) {
                echo '<p>Echec virement : le controle d\'integrite a echoue.</p>';
              }
              if (isset($_REQUEST["trf_ok"])) {
                echo '<p>Virement effectue avec succes.</p>';
              }
              if (isset($_REQUEST["bad_mt"])) {
                echo '<p>Le montant saisi est incorrect : '.htmlentities($_REQUEST["bad_mt"], ENT_QUOTES).'</p>';
              }
              ?>
          </div>
        </form>
        </article>
        
        
    </section>

</body>
</html>