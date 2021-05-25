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
    	<?php 
    	if ($_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {
    	    echo "<input type=\"hidden\" name=\"action\" value=\"disconnect\">";
    	    echo "<button class=\"btn-logout form-btn\">Deconnexion</button>";
    	}
    	else {
    	    echo "<input type=\"hidden\" name=\"action\" value=\"retour_ficheclient\">";
    	    echo "<button class=\"btn-logout form-btn\">Retour a la fiche client</button>";
    	}
    	?>
        </form>
     
        
        <h2><?php echo $_SESSION["consult_user"]["prenom"];?> <?php echo $_SESSION["consult_user"]["nom"];?> - Mon compte</h2>
    </header>
    
    <section>

        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Vos informations personnelles</span>
              </div>
              <div class="field">
                  <label>Login : </label><span><?php echo $_SESSION["consult_user"]["login"];?></span>
              </div>
              <div class="field">
                  <label>Profil : </label><span><?php echo $_SESSION["consult_user"]["profil_user"];?></span>
              </div>
          </div>
        </article>
        
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
			<div class="fieldset">
				<input type="hidden" name="action" value="virement">
				<button class="form-btn">Effectuer un virement.</button>
				</div>
			</form>
		</article>
		
		
		<?php 
		echo $_SESSION["consult_user"]["id_user"] . "  " . $_SESSION["connected_user"]["id_user"] . " " . $_SESSION["profil"];
		if ($_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {
		    
		    echo "<article>";
		    echo "<form method=\"POST\" action=\"myController.php\">";
		    echo "<div class=\"fieldset\">";
		    echo "<input type=\"hidden\" name=\"action\" value=\"message\">";
		    echo "<button class=\"form-btn\">Afficher les messages.</button>";
		    echo "</div></form></article>";
		}
		
		?>
	
		
		<?php 
		if ($_SESSION["profil"] == "EMPLOYE" && $_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {
		    echo "<article>";
		    echo "<form method=\"POST\" action=\"myController.php\">";
		    echo "<div class=\"fieldset\">";
		    echo "<input type=\"hidden\" name=\"action\" value=\"fichlist\">";
		    echo "<button class=\"form-btn\">Consulter la liste des fichiers clients.</button>";
		    echo "</div></form></article>";
		}
		
		?>

        
        
    </section>

</body>
</html>
