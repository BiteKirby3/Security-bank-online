<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.Forum, Model.User, java.util.*,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mes abonnements</title>
</head>
<body>
	<header>
		<h2>Mes abonnements</h2>
		<form method="POST" action="Deconnexion" align="left"
			style="position: relative">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>

	</header>

	<br>
	<div class="liste">


		<%
		int id = (int) session.getAttribute("id");
		User user = User.FindByID(id);
		user.LoadForumSubscriptions();
		List<Forum> ListForum = user.getForumSubscriptions();

		if (ListForum.isEmpty()) {
			out.println("<br><p>Vous n'êtes pas actuellement abonné au forum, allez vous abonner maintenant!</p>");
			out.println("<br><form method=\"POST\" action=\"ListForum.jsp\"> "
			+ " <button class=\"form-btn\"> Abonner maintenant</button></form>");
		} else {
		%>
		<table border="1">
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Owner</th>
				<th>Afficher</th>
			</tr>
			<%
			for (int index = 0; index < ListForum.size(); index++) {

				int forumid = ListForum.get(index).getId();

				out.println("<tr>");
				out.println("<td>" + ListForum.get(index).getId() + "</td>");
				out.println("<td>" + ListForum.get(index).getTitle() + "</td>");
				out.println("<td>" + ListForum.get(index).getDescription() + "</td>");
				out.println("<td>" + ListForum.get(index).getOwner().getLogin() + "</td>");
				out.println("<td><form method=\"POST\" action=\"AfficherForum\"> "
				+ "<input type=\"hidden\" id=\"forumid\" name=\"forumid\" value=" + ListForum.get(index).getId() + ">"
				+ " <button class=\"form-btn\">Cliquez pour entrer ce forum.</button></form></td>");
				out.println("</tr>");

			}

			}
			%>
		</table>
	</div>
</body>
</html>
