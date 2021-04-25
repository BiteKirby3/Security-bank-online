<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.User, Control.UserManager, java.util.List,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/style.css">
<title>Liste de utilisateurs</title>
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
	</header>
	<h1>Liste des utilisateurs :</h1>

	<div class="liste">
		<table border="1">
			<tr>
				<th>UserID</th>
				<th>Login</th>
				<th>FirstName</th>
				<th>LastName</th>
				<th>Is_Admin</th>
				<th>gender</th>
				<th>Supprimer</th>
			</tr>

			<%
				List<User> listUser;
				try {
					listUser = User.FindAll();
					for (int index = 0; index < listUser.size(); index++) {
						out.println("<tr>");
						out.println("<td>" + listUser.get(index).getId() + "</td>");
						out.println("<td>" + listUser.get(index).getLogin() + "</td>");
						out.println("<td>" + listUser.get(index).getFirstName() + "</td>");
						out.println("<td>" + listUser.get(index).getLastName() + "</td>");
						if ("admin".equalsIgnoreCase((String) listUser.get(index).getRole())) {
							out.println("<td> Oui </td>");
						} else {
							out.println("<td> Non </td>");
						}

						out.println("<td>" + listUser.get(index).getGender() + "</td>");
						out.println("<td><form action=\"DeleteUser\"> "
								+ "<input type=\"hidden\" id=\"userid\" name=\"userid\" value="
								+ listUser.get(index).getId() + ">"
								+ " <button class=\"form-btn\">Supprimer</button></form></td>");

						out.println("</tr>");
					}
				} catch (ClassNotFoundException | SQLException ex) {
					Logger.getLogger(UserManager.class.getName()).log(Level.SEVERE, null, ex);
				}
			%>

		</table>
	</div>
</body>
</html>