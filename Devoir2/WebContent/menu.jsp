<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8" import="Model.User"%>
<%
int id = (int) session.getAttribute("id");
User user = User.FindByID(id);
%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Navigation Administrateur</title>
</head>
<body>
	<header>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
		<h2>
			Hello,
			<%=user.getFirstName()%>,
			<%=user.getLastName()%>
			!
		</h2>
	</header>

	<div class="fieldset">
		<div class="fieldset_label">
			<span>Liste des opérations de l'administrateur</span>
		</div>
		<div class="field">
			<p>
				<a href='ajouter_nv_util.jsp'>Créer un nouveau utilisateur</a>
			</p>
			<p>
				<a href='UserManager'>Afficher la liste des utilisateurs</a>
			</p>
			<p>
				<a href='GestioForum.jsp'>Gestion des Forums</a>
			</p>

		</div>
	</div>




</body>
</html>
