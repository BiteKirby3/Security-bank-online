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
  <title>Mon Compte</title>
  <link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" />
</head>
<body>
    <header>
        <form method="POST" action="myController.php">
            <input type="hidden" name="action" value="disconnect">
            <button class="btn-logout form-btn">Deconnexion</button>
        </form>
        
        <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Mon compte</h2>
    </header>
    
    <section>

        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Vos informations personnelles</span>
              </div>
              <div class="field">
                  <label>Login : </label><span><?php echo $_SESSION["connected_user"]["login"];?></span>
              </div>
              <div class="field">
                  <label>Profil : </label><span><?php echo $_SESSION["connected_user"]["profil_user"];?></span>
              </div>
          </div>
        </article>
        
        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Votre compte</span>
              </div>
              <div class="field">
                  <label>No compte : </label><span><?php echo $_SESSION["connected_user"]["numero_compte"];?></span>
              </div>
              <div class="field">
                  <label>Solde : </label><span><?php echo $_SESSION["connected_user"]["solde_compte"];?> &euro;</span>
              </div>
          </div>
        </article>
        
        <article>
			<form method="POST" action="myController.php">
			<div class="fieldset">
				<input type="hidden" name="action" value="virement">
				<button class="form-btn">Effectuer un virement.</button>
				</div>
			</form>
		</article>
		
		<article>
			<form method="POST" action="myController.php">
			<div class="fieldset">
				<input type="hidden" name="action" value="message">
				<button class="form-btn">Afficher les messages.</button>
				</div>
			</form>
		</article>

        
    </section>

</body>
</html>
