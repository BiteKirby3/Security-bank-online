<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
<title>Ajouter un nouveau utilisateur</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h1>Créer un nouveau utilisateur</h1>
	</header>
	<form action="Validation" method="post">
		<label> First name </label> <input type="text" id="frname" name="User first name" /> <br><br>
		<label> Familly name </label> <input type="text" id="faname" name="User familly name" /> <br><br>
		<label> Email </label> <input type="email" id="email" name="User email" /> <br><br>
		<label> Password </label> <input type="password" id="psw" name="User password" /> <br><br>
		<label> male </label> <input type="radio" id="male" name="gender" value="male" checked />
		<label> female </label> <input type="radio" id="female" name="gender" value="female" /> <br><br>
		<label> Admin </label> <input type="checkbox" name="admin" value="admin" /> <br><br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>

