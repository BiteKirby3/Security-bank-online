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
<title>Navigation Administrateur</title>
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
				<span>Gestion des forums</span>
			</div>
			<div class="field">
				<p>
					<a href='ajouter_forum.jsp'>Créer un nouveau forum</a>
				</p>
				<p>
					<a href='gerer_forums.jsp'>Afficher la liste des forums</a>
				</p>

			</div>
		</div>
	</article>

	<article>
		<div class="fieldset">
			<div class="fieldset_label">
				<span>Gestion des utilisateurs</span>
			</div>
			<div class="field">
				<p>
					<a href='ajouter_nv_util.jsp'>Créer un nouveau utilisateur</a>
				</p>
				<p>
					<a href='UserManager'>Afficher la liste des utilisateurs</a>
				</p>
			</div>
		</div>
	</article>
</body>
</html>
