<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"
	import="Model.Forum, Model.User, java.util.List,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level "%>
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
<title>Gestion des abonnements</title>
</head>
<body>
	<form method="POST" action="Deconnexion">
		<button class="btn-logout form-btn">Déconnexion</button>
	</form>
	<header>
		<h1>Gestion des abonnements</h1>
	</header>

	<br>
	<div class="liste">
		<table border=1>
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Owner</th>
				<th>Abonnement</th>
			</tr>
			<%
				List<Forum> ListForum;
				try {
					ListForum = Forum.FindAll();
					for (int index = 0; index < ListForum.size(); index++) {
						int forumid = ListForum.get(index).getId();
						int userid = id;
						out.println("<tr>");
						out.println("<td>" + forumid + "</td>");
						out.println("<td>" + ListForum.get(index).getTitle() + "</td>");
						out.println("<td>" + ListForum.get(index).getDescription() + "</td>");
						out.println("<td>" + ListForum.get(index).getOwner().getLogin() + "</td>");

						List<Integer> listuser = Forum.FindAllSubscription(forumid);
						if (ListForum.get(index).getOwner().getId() == id) {
							out.println("<td>" + "Vous êtes le propriétaire de ce forum." + "</td>");
						} else if (listuser.contains(id)) {
							out.println("<td><form method=\"POST\" action=\"UnsubscribeForum\">");
							out.println("<input type=\"hidden\" name=\"userid\" value=" + id + ">");
							out.println("<input type=\"hidden\" name=\"forumid\" value=" + forumid + ">");
							out.println(" <button class=\"form-btn\">Abonné. Cliquez pour vous désabonner.</button>");
							out.println("</form></td>");
						} else {
							out.println("<td><form method=\"POST\" action=\"SubscribeForum\"> ");
							out.println("<input type=\"hidden\" id=\"userid\" name=\"userid\" value=" + id + ">");
							out.println("<input type=\"hidden\" id=\"forumid\" name=\"forumid\" value=" + forumid + ">");
							out.println(" <button class=\"form-btn\">Cliquez pour vous abonner.</button>");
							out.println("</form></td>");
						}
						out.println("</tr>");
					}
				} catch (ClassNotFoundException | SQLException ex) {
					Logger.getLogger(Forum.class.getName()).log(Level.SEVERE, null, ex);
				}
			%>
		</table>
	</div>
	<br>
</body>
</html>
