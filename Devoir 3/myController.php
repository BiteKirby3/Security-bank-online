<?php
require_once ('include.php');
require_once ('myModel.php');

session_start();

// URL de redirection par d��faut (si pas d'action ou action non reconnue)
$url_redirect = "index.php";

if (isset($_REQUEST['action'])) {

    if ($_REQUEST['action'] == 'authenticate') {

        /* ======== AUTHENT ======== */
        // if (ipIsBanned($_SERVER['REMOTE_ADDR'])){
        // // cette IP est bloqu��e
        // $url_redirect = "vw_login.php?ipbanned";

        // } else
        if (! isset($_REQUEST['login']) || ! isset($_REQUEST['mdp']) || $_REQUEST['login'] == "" || $_REQUEST['mdp'] == "") {
            // manque login ou mot de passe

            $url_redirect = "vw_login.php?nullvalue";
        } else {
            $car_interdits = array(
                "'",
                "\"",
                ";",
                "%"
            ); // une liste de caract��res que je choisis d'interdire
            $utilisateur = findUserByLoginPwd(str_replace($car_interdits, "", $_REQUEST['login']), str_replace($car_interdits, "", $_REQUEST['mdp']), $_SERVER['REMOTE_ADDR']);

            if ($utilisateur == false) {
                // echec authentification
                $url_redirect = "vw_login.php?badvalue";
            } else {
                // authentification r��ussie
                $_SESSION["connected_user"] = $utilisateur;
                $_SESSION["listeUsers"] = findAllUsers();

                if ($utilisateur['profil_user'] == "ADMIN")
                    $url_redirect = "vw_admin.php";
                else
                    $url_redirect = "vw_accueil.php";
            }
        }
    } else if ($_REQUEST['action'] == 'disconnect') {
        /* ======== DISCONNECT ======== */
        // unset($_SESSION["connected_user"]);
        session_unset();
        $url_redirect = "vw_login.php?disconnect";
    } else if ($_REQUEST['action'] == 'transfert') {
        /* ======== TRANSFERT ======== */
        if (! isset($_REQUEST['mytoken']) || $_REQUEST['mytoken'] != $_SESSION['mytoken']) {
            // echec v��rification du token (ex : attaque CSRF)
            $url_redirect = "vw_moncompte.php?err_token";
        } else {
            if (is_numeric($_REQUEST['montant'])) {
                transfert($_REQUEST['destination'], $_SESSION["connected_user"]["numero_compte"], $_REQUEST['montant']);
                $_SESSION["connected_user"]["solde_compte"] = $_SESSION["connected_user"]["solde_compte"] - $_REQUEST['montant'];
                $url_redirect = "vw_moncompte.php?trf_ok";
            } else {
                $url_redirect = "vw_moncompte.php?bad_mt=" . $_REQUEST['montant'];
            }
        }
    } else if ($_REQUEST['action'] == 'sendmsg') {
        /* ======== MESSAGE ======== */
        addMessage($_REQUEST['to'], $_SESSION["connected_user"]["id_user"], $_REQUEST['sujet'], $_REQUEST['corps']);
        $url_redirect = "vw_moncompte.php?msg_ok";
    } else if ($_REQUEST['action'] == 'msglist') {
        /* ======== MESSAGE ======== */
        $_SESSION['messagesRecus'] = findMessagesInbox($_SESSION["connected_user"]["id_user"]);
        $url_redirect = "vw_messagerie.php";
    } else if ($_REQUEST['action'] == 'fichlist') {
        /* ======== FicheClient ======== */
        $_SESSION["listeUsers"] = findAllUsers();
        $url_redirect = "ficheclient.php";
    } else if($_REQUEST['action']=='retour'){
        /*======== RETOUR ========*/
        $url_redirect = "vw_admin.php";    
    }
}

header("Location: $url_redirect");

?>
