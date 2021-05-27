<?php
require_once ('include.php');
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
<link rel="stylesheet" type="text/css" media="all"
	href="css/mystyle.css" />
</head>
<body>
	<header>
		<form method="POST" action="myController.php">
		<input type="hidden" name="action" value="retour">
			<button class="btn-back form-btn">Retour</button>
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
				<label>Destinataire : </label> 
				<select name="to">
                    <?php
                    if ($_SESSION["profil"] == "EMPLOYE") {
                        foreach ($_SESSION['listeUsers'] as $id => $user) {
                            echo '<option value="' . $id . '">' . $id . ' ' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
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
				<textarea name="corps" cols="50" rows="5" style="resize: none;"></textarea>
			</div>
			<div class="field">
				<?php echo Securimage::getCaptchaHtml() ?>
			</div>
			<div>
				<button class="form-btn">Envoyer</button>
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
