<?php
ini_set('session.cookie_httponly', 1);
error_reporting(0);
ini_set("display_errors", 0);
session_start();
$url_redirect = "index.php";
if (! isset($_SESSION["connected_user"])) {
    // header("Location: $url_redirect");
    echo "<script> alert('Veuillez vous connecter d\'abord!!'); </script>";
    echo "<meta http-equiv='Refresh' content='0;URL=$url_redirect'>";
} else if ($_SESSION["connected_user"]["profil_user"] != "EMPLOYE") {
    echo "<script> alert('Vous n\'avez pas le droit!!'); </script>";
    echo "<meta http-equiv='Refresh' content='0;URL=\"vw_moncompte.php\"'>";
}
?>

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Gestion compte client</title>
<link rel="stylesheet" type="text/css" media="all"
	href="css/mystyle.css" />
</head>
<body>
	<header>
		<form method="POST" action="myController.php">
			<input type="hidden" name="action" value="retour_liste_client"> <input
				type="hidden" name="listePage" value="ficheclient.php">
			<button class="btn-logout form-btn">Retour</button>
		</form>

		<h2><?php echo $_SESSION["consult_user"]["prenom"];?> <?php echo $_SESSION["consult_user"]["nom"];?> - Client compte</h2>
	</header>

	<section>

		<article>
			<div class="fieldset">
				<div class="fieldset_label">
					<span>Informations clients</span>
				</div>
				<div class="field">
					<label>Login : </label><span><?php echo $_SESSION["consult_user"]["login"];?></span>
				</div>

				<div class="field">
					<label>Nom : </label><span><?php echo $_SESSION["consult_user"]["nom"];?></span>
				</div>
				<div class="field">
					<label>Prenom : </label><span><?php echo $_SESSION["consult_user"]["prenom"];?></span>
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
					<label>Numero compte : </label><span><?php echo $_SESSION["consult_user"]["numero_compte"];?></span>
				</div>
				<div class="field">
					<label>Solde : </label><span><?php echo $_SESSION["consult_user"]["solde_compte"];?> &euro;</span>
				</div>
			</div>
		</article>

		<article>
			<div class="fieldset">
				<div class="fieldset_label">
					<span>Liens Utiles</span>
				</div>
				<div class="field">
					<form method="POST" action="myController.php">
						<input type="hidden" name="action" value="virement_client">
						<button class="form-btn">Virement pour ce client.</button>
					</form>
				</div>
			</div>


		</article>






	</section>

</body>
</html>
