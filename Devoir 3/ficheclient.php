<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Liste de Clients</title>
  <link rel="stylesheet" type="text/css" media="all"  href="css/mystyle.css" />
</head>
<body>
    <header>
		<form method="POST" action="myController.php">
            <input type="hidden" name="action" value="retour">
            <input type="hidden" name="loginPage" value="vw_admin.php">
            <button class="btn-logout form-btn">Retour</button>
		</form>
		<h2>Liste de Clients</h2>
	</header>
	<br><br>

    <section>
        <article>
          <div class="liste">
			  
            <table>
              <tr><th>ID Client</th><th>Nom</th><th>Prenom</th><th>Numero Compte</th><th>Gestion</th></tr>
              <?php
              $users = $_SESSION['listeUsers'];
              
              echo $users[2];
              foreach ($_SESSION['listeUsers'] as $id => $user) {
				if ($user['profil_user'] =="USER"){
					echo '<tr>';
					echo '<td>'.$user['id_user'].'</td>';
					echo '<td>'.$user['nom'].'</td>';
					echo '<td>'.$user['prenom'].'</td>';
					echo '<td>'.$user['numero_compte'].'</td>';
					echo '<td><form method="POST" action="myController.php">';
					echo '<input type="hidden" name="action" value="gestion">';
					echo '<input type="hidden" name="login" value="'.$user['login'].'">';
					echo '<button class="form-btn">Gestion de compte du client</button>';
					echo '</form></td>';
					echo '</tr>';
				}
				
              }
               ?>
			</table>
          </div>
    
        </article>
    </section>
</body>
</html>

 
 
 
 


