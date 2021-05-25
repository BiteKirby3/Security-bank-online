<?php
require_once('include.php');
require_once('config/config.php');

function getMySqliConnection() {
  return new mysqli(DB_HOST, DB_USER, DB_PASSWD,DB_NAME);
}


function findUserByLoginPwd($login, $pwd, $ip) {
  $mysqli = getMySqliConnection();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
      $utilisateur = false;
  } else {
      // Pour faire vraiment propre, on devrait tester si le prepare et le execute se passent bien
      $stmt = $mysqli->prepare("select nom,prenom,login,id_user,numero_compte,profil_user,solde_compte from users where login=? and mot_de_passe=?");  
      $stmt->bind_param("ss", $login, $pwd); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
      $stmt->execute();
      $stmt->bind_result($nom,$prenom,$username,$id_user,$numero_compte,$profil_user,$solde_compte); // on pr¨¦pare les variables qui recevront le r¨¦sultat
      if ($stmt->fetch()) {
          // les identifiants sont corrects => on renvoie les infos de l'utilisateur
          $utilisateur = array ("nom" => $nom,
                                "prenom" => $prenom,
                                "login" => $username,
                                "id_user" => $id_user,
                                "numero_compte" => $numero_compte,
                                "profil_user" => $profil_user,
                                "solde_compte" => $solde_compte);
      } else {
          // les identifiants sont incorrects
          $utilisateur = false;
          
          // on log l'IP ayant g¨¦n¨¦r¨¦ l'erreur
          $stmt_insert = $mysqli->prepare("insert into connection_errors(ip,error_date) values(?,CURTIME())");
          $stmt_insert->bind_param("s", $ip); // Eventuellement, g¨¦rer le cas ou l'utilisateur on est derri¨¨re un proxy en utilisant $_SERVER['HTTP_X_FORWARDED_FOR'] 
          $stmt_insert->execute();
          $stmt_insert->close();
      }
      $stmt->close();
      
      $mysqli->close();
  }

  return $utilisateur;
}

function findUserByLogin($login) {
    $mysqli = getMySqliConnection();
    
    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
        $utilisateur = false;
    } else {
        // Pour faire vraiment propre, on devrait tester si le prepare et le execute se passent bien
        $stmt = $mysqli->prepare("select nom,prenom,login,id_user,numero_compte,profil_user,solde_compte from users where login=?;");
        $stmt->bind_param("s", $login); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
        $stmt->execute();
        $stmt->bind_result($nom, $prenom, $username, $id_user, $numero_compte, $profil_user, $solde_compte); // on pr¨¦pare les variables qui recevront le r¨¦sultat
        if ($stmt->fetch()) {
            // les identifiants sont corrects => on renvoie les infos de l'utilisateur
            $utilisateur = array ("nom" => $nom,
                                "prenom" => $prenom,
                                "login" => $username,
                                "id_user" => $id_user,
                                "numero_compte" => $numero_compte,
                                "profil_user" => $profil_user,
                                "solde_compte" => $solde_compte
            );
        } 
        $stmt->close();
        
        $mysqli->close();
    }
    
    return $utilisateur;
}


function ipIsBanned($ip) {
  $mysqli = getMySqliConnection();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
      return false;
  } else {
      $stmt = $mysqli->prepare("select count(*) as nb_tentatives from connection_errors where ip=?");  
      $stmt->bind_param("s",  $ip); 
      $stmt->execute();
      $stmt->bind_result($count);
      $stmt->fetch();
      if($count > 4) {
        return true; // cette IP a atteint le nombre maxi de 5 tentatives infructueuses
      } else {
        return false;
      }
      $mysqli->close();
  } 
}


function findAllUsers() {
  $mysqli = getMySqliConnection();

  $listeUsers = array();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
  } else {
      $req="select nom,prenom,login,id_user from users";
      if (!$result = $mysqli->query($req)) {
          trigger_error('Erreur requ¨ºte BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error, E_USER_ERROR);
      } else {
          while ($unUser = $result->fetch_assoc()) {
            $listeUsers[$unUser['id_user']] = $unUser;
          }
          $result->free();
      }
      $mysqli->close();
  }

  return $listeUsers;
}


function findAllClients() {
    $mysqli = getMySqliConnection();
    
    $listeClients = array();
    
    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
    } else {
        $req="select * from users where profil_user = 'CLIENT';";
        if (!$result = $mysqli->query($req)) {
            trigger_error('Erreur requ¨ºte BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error, E_USER_ERROR);
        } else {
            while ($unUser = $result->fetch_assoc()) {
                $listeClients[$unUser['id_user']] = $unUser;
            }
            $result->free();
        }
        $mysqli->close();
    }
    
    return $listeClients;
}


function findAllEmployes() {
    $mysqli = getMySqliConnection();
    
    $listeEmployes = array();
    
    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
    } else {
        $req="select nom,prenom,login,id_user from users where profil_user = 'EMPLOYE';";
        if (!$result = $mysqli->query($req)) {
            trigger_error('Erreur requ¨ºte BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error, E_USER_ERROR);
        } else {
            while ($unUser = $result->fetch_assoc()) {
                $listeEmployes[$unUser['id_user']] = $unUser;
            }
            $result->free();
        }
        $mysqli->close();
    }
    
    return $listeEmployes;
}



function transfert($dest, $src, $mt) {
  $mysqli = getMySqliConnection();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
      $utilisateur = false;
  } else {
      // Pour faire vraiment propre, on devrait tester si le execute et le prepare se passent bien
      $stmt = $mysqli->prepare("update users set solde_compte=solde_compte+? where numero_compte=?");  
      $stmt->bind_param("ds", $mt, $dest); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
      $stmt->execute(); 
      $stmt->close();

      $stmt = $mysqli->prepare("update users set solde_compte=solde_compte-? where numero_compte=?");  
      $stmt->bind_param("ds", $mt, $src); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
      $stmt->execute();
      $stmt->close();
  
      $mysqli->close();
  }

  return $utilisateur;
}


function findMessagesInbox($userid) {
  $mysqli = getMySqliConnection();

  $listeMessages = array();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
  } else {
      // Pour faire vraiment propre, on devrait tester si le prepare et le execute se passen bien
      $stmt = $mysqli->prepare("select id_msg,sujet_msg,corps_msg,u.nom,u.prenom from messages m, users u where m.id_user_from=u.id_user and id_user_to=?");  
      $stmt->bind_param("i", $userid); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
      $stmt->execute();
      $stmt->bind_result($id_msg, $sujet_msg, $corps_msg, $nom, $prenom); // on pr¨¦pare les variables qui recevront le r¨¦sultat
      while ($stmt->fetch()) {
          $unMessage = array ("id_msg" => $id_msg, "sujet_msg" => $sujet_msg, "corps_msg" => $corps_msg, "nom" => $nom, "prenom" => $prenom);
          $listeMessages[$id_msg] = $unMessage;
      } 
      $stmt->close();
      
      $mysqli->close();
  }

  return $listeMessages;
}


function addMessage($to, $from, $subject, $body) {
  $mysqli = getMySqliConnection();

  if ($mysqli->connect_error) {
      trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
  } else {
      // Pour faire vraiment propre, on devrait tester si le execute et le prepare se passent bien
      $stmt = $mysqli->prepare("insert into messages(id_user_to,id_user_from,sujet_msg,corps_msg) values(?,?,?,?)");  
      $stmt->bind_param("iiss", $to, $from, $subject, $body); // on lie les param¨¨tres de la requ¨ºte pr¨¦par¨¦e avec les variables
      $stmt->execute(); 
      $stmt->close();

      $mysqli->close();
  }

}

?>
