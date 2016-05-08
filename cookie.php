<?php
$connected = FALSE;
include('connection.php');
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $sql = "SELECT * FROM SESSIONS WHERE TOKEN = '" . $token . "';";
    $requete = $bdd->query($sql);
    if ($requete != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $resultat = $resultats[0];
            if (strtotime($resultat['expiration_date']) < time()) {
                $sql = "DELETE FROM SESSIONS WHERE TOKEN = '" . $token . "';";
                $requete = $bdd->query($sql);
                if ($requete == FALSE) {
                    print("There was a problem contacting the database");
                }
            } else {
                $connected = TRUE;
                $sql = "SELECT * FROM USERS WHERE ID ='" . $resultat['id_user'] . "';";
                $requete = $bdd->query($sql);
                if ($requete != FALSE) {
                    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                    $user_infos = $resultats[0];
                } else {
                    print("There was a problem receiving informations from the database");
                }
            }
        }
    } else {
        print("There was a problem receiving informations from the database");
    }
}