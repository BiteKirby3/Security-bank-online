<?php
require_once('include.php');
require_once("securimage/securimage.php");

session_start();

if (!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
	// utilisateur non connecte
	header('Location: vw_login.php');
	exit();
}
?>

<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Messages</title>
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
			<button class="btn-back form-btn btn btn-secondary" style="margin-right:50px;">Retour</button>
		</form>


		<h2 style="text-align: center; margin-top:30px;"><?php echo $_SESSION["connected_user"]["prenom"]; ?> <?php echo $_SESSION["connected_user"]["nom"]; ?> - Messages recus</h2>
	</header>

	<article style="text-align: center;">
		<form method="POST" action="myController.php">
			<input type="hidden" name="action" value="sendmsg">

			<div class="fieldset_label" style="background-color:#28a745; margin-left:20%; margin-right:20%;">
				<span>Envoyer un message</span>
			</div>
			<div class="field">
				<label>Destinataire : </label>
				<select name="to">
					<?php
					if ($_SESSION["profil"] == "EMPLOYE") {
						foreach ($_SESSION['listeUsers'] as $id => $user) {
							if ($user['login'] != $_SESSION["connected_user"]["login"]) {
								echo '<option value="' . $id . '">' . $id . ' ' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
							}
						}
					} else {
						foreach ($_SESSION['listeEmployes'] as $id => $user) {
							echo '<option value="' . $id . '">' . $id . ' ' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
						}
					}
					?>
				</select>
			</div>
			<div class="field">
				<label>Sujet : </label><input type="text" size="53" name="sujet">
			</div>
			<div class="field">
				<label>Message : </label>
				<textarea name="corps" cols="55" rows="5" style="resize: none;"></textarea>
			</div>
			<div class="field">
				<?php echo Securimage::getCaptchaHtml() ?>
			</div>
			<div>
				<button class="form-btn btn btn-success">Envoyer</button>
			</div>
			<?php
			if (isset($_REQUEST["msg_ok"])) {
				echo '<p style="color:green;">Message envoyé avec succès.</p>';
			} else if (isset($_REQUEST["msg_codeerreur"])) {
				echo '<p style="color:red;">Message non envoyé comme le code n\'est pas correct </p>';
			}
			?>
		</form>
	</article>

	<section>
		<article>
			</br>
			<div class="liste">
				<table>
					<tr>
						<th>Expediteur</th>
						<th>Sujet</th>
						<th>Message</th>
					</tr>
					<?php
					foreach ($_SESSION['messagesRecus'] as $cle => $message) {
						echo '<tr>';
						echo '<td>' . $message['nom'] . ' ' . $message['prenom'] . '</td>';
						echo '<td>' . htmlentities($message['sujet_msg'], ENT_QUOTES) . '</td>';
						echo '<td>' . htmlentities($message['corps_msg'], ENT_QUOTES) . '</td>';
						echo '</tr>';
					}
					?>
				</table>
			</div>

		</article>
	</section>
</body>

</html>