<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8" import="Model.User"%>
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
<title>Navigation Utilisateur</title>
</head>

<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h1>
			<%
				out.println("Hello, " + user.getFirstName() + " " + user.getLastName());
			%>
		</h1>
	</header>

	<article>
		<div class="fieldset">
			<div class="fieldset_label">
				<span>Vos informations:</span>
			</div>
			<div class="field">
				<label>UserID : </label><span><%=user.getId()%></span>
			</div>
			<div class="field">
				<label>login : </label><span><%=user.getLogin()%></span>
			</div>
			<div class="field">
				<label>Gender : </label><span><%=user.getGender()%></span>
			</div>
			<div class="field">
				<label>Role : </label><span><%=user.getRole()%></span>
			</div>
		</div>
	</article>
	
	<article>
		<div class="fieldset">
			<div class="fieldset_label">
				<span>Gestion des forums</span>
			</div>
			<div class="field">
				<p>
					<a href='ajouter_forum.jsp'>Créer un nouveau forum</a>
				</p>
				<p>
					<a href='listForums.jsp'>Gestion des abonnements</a>
				</p>
				<p>
					<a href='listMesForums.jsp'>Liste de mes forums (vous êtes le propriétaire de ce forum).</a>
				</p>
				<p>
					<a href='listMesInvitations.jsp'>Liste de mes invitations (vous êtes le membre de ce forum).</a>
				</p>
			</div>
		</div>
	</article>


</body>
</html>
