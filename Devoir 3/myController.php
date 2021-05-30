<?php
require_once ('include.php');
require_once ('myModel.php');
require_once("securimage/securimage.php");

session_start();

// URL de redirection par defaut (si pas d'action ou action non reconnue)
$url_redirect = "index.php";

if (isset($_REQUEST['action'])) {

    if ($_REQUEST['action'] == 'authenticate') {

        /* ======== AUTHENT ======== */
        if (ipIsBanned(getRealIp())){
            // cette IP est bloquée
            $url_redirect = "vw_login.php?ipbanned";
        } else if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp']) || $_REQUEST['login'] == "" || $_REQUEST['mdp'] == "") {
            // manque login ou mot de passe
            $url_redirect = "vw_login.php?nullvalue";
        } else if (!verifyPassword($_REQUEST['mdp'])){
            $url_redirect = "vw_login.php?mdpFormatError";
        } else {
            $car_interdits = array("'", "\"", ";","%"); // une liste de caractères que je choisis d'interdire
            $utilisateur = findUserByLoginPwd(str_replace($car_interdits, "", $_REQUEST['login']), str_replace($car_interdits, "", $_REQUEST['mdp']), getRealIp());
            if ($utilisateur == false) {
                // echec authentification
                $url_redirect = "vw_login.php?badvalue";
            } else {    
                // authentification réussie
                $_SESSION["connected_user"] = $utilisateur;
                $_SESSION["listeUsers"] = findAllUsers();
                $_SESSION["listeClients"] = findAllClients();
                $_SESSION["listeEmployes"] = findAllEmployes();
                $_SESSION["profil"] = $utilisateur['profil_user'];
                $_SESSION["consult_user"] = $utilisateur;
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
            // echec verification du token (ex : attaque CSRF)
            $url_redirect = "vw_virement.php?err_token";
        } else {
            $car_interdits = array("'", "\"", ";","%"); // une liste de caractères que je choisis d'interdire
            $utilisateur = findUserByLoginPwd($_SESSION["connected_user"]["login"], str_replace($car_interdits, "", $_REQUEST['mdp']), getRealIp());
            if(!findAccountByNumero($_REQUEST['destination'])){
                $url_redirect = "vw_virement.php?account=".$_REQUEST['account']."&destination_error";
            } else if(!$utilisateur){
                $url_redirect = "vw_login.php?badvalue";
            } else if($_REQUEST['destination']==$_REQUEST['account']){
                $url_redirect = "vw_virement.php?account=".$_REQUEST['account']."&account_destination_same";
            } else if (is_numeric($_REQUEST['montant']) && $_REQUEST['montant'] > 0 && $_REQUEST['montant'] <= $_SESSION["consult_user"]["solde_compte"]) {
                transfert($_REQUEST['destination'], $_REQUEST['account'] , $_REQUEST['montant']);
                $_SESSION["consult_user"]["solde_compte"] == $_SESSION["consult_user"]["solde_compte"] - $_REQUEST['montant'];
                if($_SESSION["connected_user"]["numero_compte"] == $_REQUEST['account']){
                    $_SESSION["connected_user"]["solde_compte"] = $_SESSION["connected_user"]["solde_compte"] - $_REQUEST['montant'];
                }
                if($_SESSION["connected_user"]["numero_compte"] == $_REQUEST['destination']){
                    $_SESSION["connected_user"]["solde_compte"] = $_SESSION["connected_user"]["solde_compte"] + $_REQUEST['montant'];
                }
                $url_redirect = "vw_virement.php?account=".$_REQUEST['account']."&trf_ok";
            } else {
                $url_redirect = "vw_virement.php?account=".$_REQUEST['account']."&bad_mt=" . $_REQUEST['montant'];
            }
        }
    } else if ($_REQUEST['action'] == 'sendmsg') {
        /* ======== MESSAGE ======== */
        $image = new Securimage();
        if ($image->check($_POST['captcha_code']) == true) {
            addMessage($_REQUEST['to'], $_SESSION["connected_user"]["id_user"], $_REQUEST['sujet'], $_REQUEST['corps']);
            $url_redirect = "vw_messagerie.php?msg_ok";
        } else {
            $url_redirect = "vw_messagerie.php?msg_codeerreur";
        }
    } else if ($_REQUEST['action'] == 'fichlist') {
        /* ======== FicheClient ======== */
        $_SESSION["listeUsers"] = findAllUsers();
        $url_redirect = "ficheclient.php";
    } else if ($_REQUEST['action'] == 'retour') {
        $url_redirect = "vw_accueil.php";
    } else if ($_REQUEST['action'] == 'virement') {
        // $_SESSION["consult_user"] = $_SESSION["connected_user"];
        $url_redirect = "vw_virement.php?account=".$_SESSION["consult_user"]["numero_compte"];
    } else if ($_REQUEST['action'] == 'message') {
        $_SESSION['messagesRecus'] = findMessagesInbox($_SESSION["connected_user"]["id_user"]);
        $url_redirect = "vw_messagerie.php";
    } else if ($_REQUEST['action'] == 'gestion') {
        /* ========Consulter un compte user ======== */
        $consult_user = findUserByLogin($_REQUEST['login']);
        // stocker l'utilisateur que l'employe consulte
        $_SESSION["consult_user"] = $consult_user;
        $url_redirect = "vw_accueil.php";
    } else if ($_REQUEST['action'] == 'virement_client') {
        $url_redirect = "vw_virement.php";
    } else if ($_REQUEST['action'] == 'retour_ficheclient') {
        $_SESSION["consult_user"] = $_SESSION["connected_user"];
        $url_redirect = "ficheclient.php";
    }
}

header("Location: $url_redirect");

?>
