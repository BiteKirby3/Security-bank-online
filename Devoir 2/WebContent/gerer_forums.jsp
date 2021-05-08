<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.Forum,java.util.List,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>


<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/style.css">
<title>Add/Supprer un Forum</title>
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h2>Page de gestion des Forum</h2>
	</header>

	<div class="liste">
		<table border="1">
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Owner</th>
				<th>Suppression</th>
			</tr>

			<%
				List<Forum> ListForum;
				try {
					ListForum = Forum.FindAll();
					for (int index = 0; index < ListForum.size(); index++) {
						out.println("<tr>");
						out.println("<td>" + ListForum.get(index).getId() + "</td>");
						out.println("<td>" + ListForum.get(index).getTitle() + "</td>");
						out.println("<td>" + ListForum.get(index).getDescription() + "</td>");
						out.println("<td>" + ListForum.get(index).getOwner().getLogin() + "</td>");
						out.println("<td><form action=\"DeleteForum\">"
								+ "<input type=\"hidden\" id=\"forumid\" name=\"forumid\" value="
								+ ListForum.get(index).getId() + ">"
								+ " <button class=\"form-btn\">Supprimer</button></form></td>");
						out.println("</tr>");
					}
				} catch (ClassNotFoundException | SQLException ex) {
					Logger.getLogger(Forum.class.getName()).log(Level.SEVERE, null, ex);
				}
			%>
		</table>
	</div>
</body>
</html>
