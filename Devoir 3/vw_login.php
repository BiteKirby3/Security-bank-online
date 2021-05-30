<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Connexion</title>
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Merienda+One">
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script
	src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" media="all"  href="css/login.css" />
	<script src="js/myscript.js"></script>
</head>

<body>
	<div class="login-form">
		<form action="myController.php" method="post">
			<input type="hidden" name="action" value="authenticate">
			<div class="avatar">
				<i class="material-icons">&#xE7FF;</i>
			</div>
			<h4 class="modal-title">Login to Your Account</h4>
			<div class="form-group">
				<input type="text" class="form-control" id="login" name="login"
					placeholder="Login" required="required">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="mdp" name="mdp"
					placeholder="Mot de passe" required="required">
			</div>
			<div class="form-group small clearfix" style="min-height: 10px;">
				<p id="alarm"></p>
			</div>
			<button class="btn btn-primary btn-block btn-lg">Login</button>
		</form>
	</div>
	<section>
<?php
if (isset($_REQUEST["nullvalue"])) {
    echo '<script>document.getElementById("alarm").innerHTML = "Merci de saisir votre login et votre mot de passe.";</script>';
} else if (isset($_REQUEST["badvalue"])) {
    echo '<script>document.getElementById("alarm").innerHTML = "Votre login/mot de passe est incorrect.";</script>';
} else if (isset($_REQUEST["ipbanned"])) {
    echo '<script>document.getElementById("alarm").innerHTML = "Nombre de tentatives maximal atteint ! Contactez votre gestionnaire.";</script>';
} else if (isset($_REQUEST["mdpFormatError"])) {
    echo '<script>document.getElementById("alarm").innerHTML = "Le mot de passe doit contenir au moins 8 caractères (chiffres ou lettres), avec au moins 1 chiffre, 1 lettre majuscule et 1 lettre minuscule.";</script>';
} else if (isset($_REQUEST["disconnect"])) {
    echo '<script>document.getElementById("alarm").innerHTML = "Vous avez bien ete deconnecte.";</script>';
}
?>
</section>
</body>
</html>