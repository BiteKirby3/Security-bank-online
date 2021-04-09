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
<title>Accueil</title>
</head>

<body>
	<header>
		<h1>
			Hello
			<%=user.getFirstName()%>,
			<%=user.getLastName()%>
			!
		</h1>
		<form method="POST" action="Deconnexion">
			<button class="btn-logout form-btn">Déconnexion</button>
		</form>
	</header>

	<div class="fieldset">
		<div class="fieldset_label">
			<h1>Vos informations:</h1>
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
		<div class="field">
			<p>
				<a href='ListForum.jsp'> Gestion des abonnements </a>
			</p>
		</div>
		<div class="field">
			<p>
				<a href='ListMesForum.jsp'> Liste de mes forums </a>
			</p>
		</div>
	</div>



</body>
</html>
