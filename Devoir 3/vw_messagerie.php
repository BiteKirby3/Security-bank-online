<?php
require_once ('include.php');

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
<link rel="stylesheet" type="text/css" media="all"
	href="css/mystyle.css" />
</head>
<body>
	<header>
		<form method="POST" action="myController.php">
			<button class="btn-back form-btn">Retour</button>
		</form>
		<form method="POST" action="myController.php">
			<input type="hidden" name="action" value="disconnect">
			<button class="btn-logout form-btn">Deconnexion</button>
		</form>

		<h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Messages recus</h2>
	</header>

	<article>
		<form method="POST" action="myController.php">
			<input type="hidden" name="action" value="sendmsg">

			<div class="fieldset_label">
				<span>Envoyer un message</span>
			</div>
			<div class="field">
				<label>Destinataire : </label> <select name="to">
                    <?php
                    foreach ($_SESSION['listeEmployes'] as $id => $user) {
                        echo '<option value="' . $id . '">' . $user['nom'] . ' ' . $user['profil_user'] . '</option>';
                    }
                    ?>
                  </select>
			</div>
			<div class="field">
				<label>Sujet : </label><input type="text" size="53" name="sujet">
			</div>
			<div class="field">
				<label>Message : </label>
				<textarea name="corps" cols="50" rows="5" style="resize: none;"></textarea>
				<br>
				<button class="form-btn">Envoyer</button>
                <?php
                    if (isset($_REQUEST["msg_ok"])) {
                        echo '<p>Message envoye avec succes.</p>';
                    }
                ?>
              
			</div>
		</form>
	</article>

	<section>
		<article>

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
