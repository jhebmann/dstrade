<?php
include('connection.php');
$sql = "DELETE FROM USERS WHERE ID>1";
$requete = $bdd->query($sql);
if ($requete != FALSE) {
    print("Database cleaned !");
} else {
    print("There was a problem receiving informations from the database");
}