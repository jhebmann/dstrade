<?php
$connected = FALSE;
include('connection.php');

$sql = "DELETE FROM SESSIONS WHERE EXPIRATION_DATE < '" . date('Y-m-d H:i:s') . "';";
$requete = $bdd->query($sql);
if ($requete == FALSE) {
    header('Location: error?src=' . $_SERVER['REQUEST_URI']);
}

if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $sql = "SELECT * FROM SESSIONS WHERE TOKEN = '" . $token . "';";
    $requete = $bdd->query($sql);
    if ($requete != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $resultat = $resultats[0];
            /*if (strtotime($resultat['expiration_date']) < time()) {
                $sql = "DELETE FROM SESSIONS WHERE TOKEN = '" . $token . "';";
                $requete = $bdd->query($sql);
                if ($requete == FALSE) {
                    header('Location: error?src=' . $_SERVER['REQUEST_URI']);
                }
            } else {*/
            $connected = TRUE;
            $sql = "SELECT * FROM USERS WHERE ID ='" . $resultat['id_user'] . "';";
            $requete = $bdd->query($sql);
            if ($requete != FALSE) {
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                $user_infos = $resultats[0];
            } else {
                header('Location: error?src=' . $_SERVER['REQUEST_URI']);
            }
            //}
        }
    } else {
        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
    }
}