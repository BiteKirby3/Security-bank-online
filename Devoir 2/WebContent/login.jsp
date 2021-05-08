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
<title>Login page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<header>
		<h1>Login page</h1>
	</header>
	<section>
		<div class="login-page">
			<div class="form">
				<form action="Connexion" method="POST">
					<input type="text" id="username" name="username" placeholder="login" required /> 
					<input type="password" id="pass" name="password" placeholder="mot de passe (8 characters minimum)" required />
					<button>Sign in</button>
				</form>
			</div>
		</div>
	</section>
</body>
</html>
