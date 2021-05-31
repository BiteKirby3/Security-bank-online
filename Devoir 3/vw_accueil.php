<?php
require_once('include.php');

session_start();

if (!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
    // utilisateur non connecte
    header('Location: vw_login.php');
    exit();
}

$mytoken = bin2hex(random_bytes(128)); // token qui va servir a prevenir des attaques CSRF
$_SESSION["mytoken"] = $mytoken;
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Mon Compte</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/mystyle.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <form method="POST" action="myController.php">
            <?php
            if ($_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {
                echo "<input type=\"hidden\" name=\"action\" value=\"disconnect\">";
                echo "<button class=\"btn btn-secondary btn-logout form-btn\" style=\"margin-right:50px;\">Deconnexion</button>";
            } else {
                echo "<input type=\"hidden\" name=\"action\" value=\"retour_ficheclient\">";
                echo "<button class=\"btn btn-secondary btn-logout form-btn\" style=\"margin-right:50px;\">Retour a la fiche client</button>";
            }
            ?>
        </form>

        <h2 style="text-align: center; margin-top:30px;"><?php echo $_SESSION["consult_user"]["prenom"]; ?> <?php echo $_SESSION["consult_user"]["nom"]; ?> - Mon compte</h2>
    </header>

    <section>
        <article>
            <div class="fieldset">
                <div class="fieldset_label" style="background-color:#28a745;">
                    <span>Vos informations personnelles</span>
                </div>
                <div class="field">
                    <label>Login : </label><span><?php echo $_SESSION["consult_user"]["login"]; ?></span>
                </div>
                <div class="field">
                    <label>Profil : </label><span><?php echo $_SESSION["consult_user"]["profil_user"]; ?></span>
                </div>
            </div>
        </article>

        <article>
            <div class="fieldset">
                <div class="fieldset_label" style="background-color:#28a745;">
                    <span>Votre compte</span>
                </div>
                <div class="field">
                    <label>No compte : </label><span><?php echo $_SESSION["consult_user"]["numero_compte"]; ?></span>
                </div>
                <div class="field">
                    <label>Solde : </label><span><?php echo $_SESSION["consult_user"]["solde_compte"]; ?> &euro;</span>
                </div>
            </div>
        </article>

        <article>
            <div class="fieldset">
                <div class="fieldset_label" style="background-color:#28a745;">
                    <span>Liens utiles</span>
                </div>
                <form method="POST" action="myController.php" style="margin-top:20px;">
                    <input type="hidden" name="action" value="virement">
                    <button class="form-btn btn btn-primary">Effectuer un virement.</button>
                </form>

                <?php
                #echo $_SESSION["consult_user"]["id_user"] . "  " . $_SESSION["connected_user"]["id_user"] . " " . $_SESSION["profil"];
                if ($_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {

                    echo "<form method=\"POST\" action=\"myController.php\" style=\"margin-top:30px;\">";
                    echo "<input type=\"hidden\" name=\"action\" value=\"message\">";
                    echo "<button class=\"form-btn btn btn-success\">Afficher les messages.</button>";
                    echo "</form>";
                }
                ?>
                <?php
                if ($_SESSION["profil"] == "EMPLOYE" && $_SESSION["consult_user"]["id_user"] == $_SESSION["connected_user"]["id_user"]) {
                    echo "<form method=\"POST\" action=\"myController.php\" style=\"margin-top:30px;\">";
                    echo "<input type=\"hidden\" name=\"action\" value=\"fichlist\">";
                    echo "<button class=\"form-btn btn btn-warning\">Consulter la liste des fichiers clients.</button>";
                    echo "</form>";
                }

                ?>

            </div>
        </article>
    </section>

</body>

</html>