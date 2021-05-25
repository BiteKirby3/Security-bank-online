<?php
require_once ('include.php');
require_once ('myModel.php');

session_start();

// URL de redirection par d¨¦faut (si pas d'action ou action non reconnue)
$url_redirect = "index.php";

if (isset($_REQUEST['action'])) {

    if ($_REQUEST['action'] == 'authenticate') {

        /* ======== AUTHENT ======== */
        // if (ipIsBanned($_SERVER['REMOTE_ADDR'])){
        // // cette IP est bloqu¨¦e
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
            ); // une liste de caract¨¨res que je choisis d'interdire
            $utilisateur = findUserByLoginPwd(str_replace($car_interdits, "", $_REQUEST['login']), str_replace($car_interdits, "", $_REQUEST['mdp']), $_SERVER['REMOTE_ADDR']);

            if ($utilisateur == false) {
                // echec authentification
                $url_redirect = "vw_login.php?badvalue";
            } else {
                // authentification r¨¦ussie
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
            // echec v¨¦rification du token (ex : attaque CSRF)
            $url_redirect = "vw_virement.php?err_token";
        } else {
            if (is_numeric($_REQUEST['montant'])) {
                transfert($_REQUEST['destination'], $_SESSION["connected_user"]["numero_compte"], $_REQUEST['montant']);
                $_SESSION["connected_user"]["solde_compte"] = $_SESSION["connected_user"]["solde_compte"] - $_REQUEST['montant'];
                $url_redirect = "vw_virement.php?trf_ok";
            } else {
                $url_redirect = "vw_virement.php?bad_mt=" . $_REQUEST['montant'];
            }
        }
    } else if ($_REQUEST['action'] == 'sendmsg') {
        /* ======== MESSAGE ======== */
        addMessage($_REQUEST['to'], $_SESSION["connected_user"]["id_user"], $_REQUEST['sujet'], $_REQUEST['corps']);
        $url_redirect = "vw_messagerie.php?msg_ok";
    } else if ($_REQUEST['action'] == 'msglist') {
        /* ======== MESSAGE ======== */
        $_SESSION['messagesRecus'] = findMessagesInbox($_SESSION["connected_user"]["id_user"]);
        $url_redirect = "vw_messagerie.php";
    } else if ($_REQUEST['action'] == 'fichlist') {
        /* ======== FicheClient ======== */
        $_SESSION["listeUsers"] = findAllUsers();
        $url_redirect = "ficheclient.php";
    } else if($_REQUEST['action']=='retour'){
        
        $url_redirect = "vw_accueil.php";    
    } else if($_REQUEST['action']=='virement'){
        //$_SESSION["consult_user"] = $_SESSION["connected_user"];
        $url_redirect = "vw_virement.php";
    } else if($_REQUEST['action']=='message'){
        
        $url_redirect = "vw_messagerie.php";
        
    } else if ($_REQUEST['action'] == 'gestion'){
        /*========Consulter un compte user ========*/
        $consult_user = findUserByLogin($_REQUEST['login']);
        
        // stocker l'utilisateur que l'employ¨¦ consulte
        $_SESSION["consult_user"] = $consult_user;
        $url_redirect = "vw_accueil.php";
        
    } else if ($_REQUEST['action'] == 'virement_client'){
        
        $url_redirect = "vw_virement.php";
        
    } 
}

header("Location: $url_redirect");

?>
