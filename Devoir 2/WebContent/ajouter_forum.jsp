<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.User, Control.UserManager, java.util.List,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>
<!DOCTYPE html>

<html>
<head>
<title>Ajouter un Forum</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="all"
	href="<%=request.getContextPath()%>/css/style.css"></link>
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h1>Créer un nouveau forum</h1>
	</header>
	<form action="AddForum" method="post">
		<label> Titre </label> <input type="text" id="forum title"
			name="forum title" /> <br>
		<br> <label> Description </label>
		<textarea id="description" name="description"></textarea>
		<br><br>
		<input type="submit" value="Add">
	</form>

</body>
</html>
