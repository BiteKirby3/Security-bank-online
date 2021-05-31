<?php
  require_once('include.php');
  require_once('myModel.php');

  session_start();
  if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
      // utilisateur non connecte
      header('Location: vw_login.php');      
      exit();
  } else if($_SESSION["connected_user"]["profil_user"] == "CLIENT" && $_SESSION["connected_user"]["numero_compte"]!=$_GET["account"]){
    header('HTTP/1.0 403 Forbidden');
    die("Désolé, vous n'avez pas le droit de consulter cette page !");
  } else if ($_SESSION["connected_user"]["profil_user"] == "EMPLOYE"){
    $found = false;
    foreach ($_SESSION['listeClients'] as $client) {
      if($client["numero_compte"]==$_GET["account"])
        $found = true;
      if($found){
        break; 
      }
    } 
    if($_GET["account"]==$_SESSION["connected_user"]["numero_compte"]){
      $found = true;
    }
    if(!$found){
      header("HTTP/1.0 404 Not Found");
      die("Oops! Page non trouvée !");
    }
  }
  
  $mytoken = bin2hex(random_bytes(128)); // token qui va servir a prevenir des attaques CSRF 
  $_SESSION["mytoken"] = $mytoken;

  $consult_user = findUserByAccount($_GET["account"]);
  // stocker l'utilisateur que l'employe consulte
  $_SESSION["consult_user"] = $consult_user;
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Virement</title>
  <link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" />
  <link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
	integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
	crossorigin="anonymous"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	crossorigin="anonymous"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
	integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <form method="POST" action="myController.php">
            <input type="hidden" name="action" value="retour">
            <button class="btn-logout form-btn btn btn-secondary" style="margin-right:50px;">Retour</button>
        </form>
        
        <h2 style="margin-top: 30px; text-align:center;"><?php echo $_SESSION["consult_user"]["prenom"];?> <?php echo $_SESSION["consult_user"]["nom"];?> - Virement</h2>
    </header>
    
    <section>

        
        <article>
          <div class="fieldset">
              <div class="fieldset_label" style="background-color:#28a745;">
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
          <div class="fieldset" style="width:600px;">
              <div class="fieldset_label" style="background-color:#28a745;">
                  <span>Transferer de l'argent</span>
              </div>
              <input type="hidden" name="account" value="<?php echo htmlspecialchars($_GET["account"]); ?>">
              <div class="field">
                  <label style="width:220px;">N° compte destinataire : </label>
                  <input type="text" style="margin-left:230px;" size="20" name="destination" required="required">
              </div>
              <div class="field">
                  <label style="width:220px;">Montant à transférer : </label>
                  <input type="text" style="margin-left:230px;" size="10" name="montant" required="required">
              </div>
              <div class="field">
                  <label style="width:220px;">Retaper votre mot de passe : </label>
                  <input type="password" style="margin-left:230px;" id="mdp" name="mdp" required="required">
              </div>
              <button class="form-btn btn btn-primary" style="margin-left:40%;">Transférer</button>
              <?php
              if (isset($_REQUEST["err_token"])) {
                echo '<p style="color:red;">Echec virement : le controle d\'integrite a echoue.</p>';
              }
              if (isset($_REQUEST["compte_error"])) {
                echo '<p style="color:red;">Le compte à créditer n\'existe pas.</p>';
              }
              if (isset($_REQUEST["destination_error"])) {
                echo '<p style="color:red;">Le compte à débiter n\'existe pas.</p>';
              }
              if (isset($_REQUEST["account_destination_same"])) {
                echo '<p style="color:red;">Vous ne pouvez effectuer un virement que de votre propre compte vers un autre compte.</p>';
              }
              if (isset($_REQUEST["trf_ok"])) {
                echo '<p style="color:green;">Virement effectué avec succes.</p>';
              }
              if (isset($_REQUEST["bad_mt"])) {
                echo '<p style="color:red;">Le montant saisi est incorrect : '.htmlentities($_REQUEST["bad_mt"], ENT_QUOTES).'</p>';
              }
              ?>
          </div>
        </form>
        </article>
        
        
    </section>

</body>
</html>