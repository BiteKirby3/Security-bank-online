<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.Forum, Model.User, java.util.*,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>
<%
	if (session.getAttribute("id") == null) {
		response.sendRedirect("login.jsp");
		return;
	}
	int id = (int) session.getAttribute("id");
	User user = User.FindByID(id);
%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/style.css">
<title>Mes forums</title>
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion" align="left"
			style="position: relative">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h1>Mes abonnements</h1>
	</header>

	<br>
	<div class="liste">
		<%
			user.LoadMyForums();
			List<Forum> ListForum = user.getMyForums();
			if (ListForum.isEmpty()) {
				out.println("<br><p>Vous ne possédez aucun forum, créez maintenant votre premier forum !</p>");
				out.println("<br><form method=\"POST\" action=\"ajouter_forum.jsp\"> "
						+ " <button class=\"form-btn\">Créer votre forum</button></form>");
			} else {
		%>
		<table border="1">
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Afficher</th>
				<th>Supprimer</th>
			</tr>
			<%
				for (int index = 0; index < ListForum.size(); index++) {
						int forumid = ListForum.get(index).getId();
						out.println("<tr>");
						out.println("<td>" + ListForum.get(index).getId() + "</td>");
						out.println("<td>" + ListForum.get(index).getTitle() + "</td>");
						out.println("<td>" + ListForum.get(index).getDescription() + "</td>");
						//entrer forum button
						out.println("<td><form method=\"POST\" action=\"AfficherForum\"> "
								+ "<input type=\"hidden\" id=\"forumid\" name=\"forumid\" value="
								+ ListForum.get(index).getId() + ">"
								+ " <button class=\"form-btn\">Cliquez pour entrer ce forum.</button></form></td>");
						//supprimer forum button
						out.println("<td><form action=\"DeleteForum\">");
						out.println("<input type=\"hidden\" name=\"forumid\" value=" + forumid + ">");
						out.println(" <button class=\"form-btn\">Supprimer</button>");
						out.println("</form></td>");
						out.println("</tr>");
					}
				}
			%>
		</table>
	</div>
</body>
</html>
