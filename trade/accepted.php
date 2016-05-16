<?php
include('../includes/cookie.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <link rel="icon" href="../lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
<body>
<?php include('../includes/menu.php'); ?>
<h1>Browse accepted offers</h1>
<?php
if (!$connected || $user_infos['role'] != "ADMIN") {
    header('Location: ..');
}
$sql = "SELECT * FROM TRADE WHERE STATE = 'ACCEPTED' ORDER BY ID DESC;";
$string = "";
if (($requete = $bdd->query($sql)) != FALSE) {
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    $string .= "<table><tr><th>Offered items</th><th>Wanted items</th><th>ID user 1</th><th>ID user 2</th><th></th></tr>";
    $ids = ['iditem1_1', 'iditem1_2', 'iditem1_3', 'iditem2_1', 'iditem2_2', 'iditem2_3'];
    $quantities = ['quantity1_1', 'quantity1_2', 'quantity1_3', 'quantity2_1', 'quantity2_2', 'quantity2_3'];
    foreach ($resultats as $resultat) {
        $string .= "<tr>";
        foreach ($ids as $key => $id) {
            if ($resultat[$id] != NULL) {
                $sql = "SELECT NAME FROM ITEM WHERE ID = " . $resultat[$id] . ";";
                if (($requete = $bdd->query($sql)) != FALSE) {
                    $resultats2 = $requete->fetchAll(PDO::FETCH_ASSOC);
                    if ($key < 3) {
                        $string .= "<td><p>" . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . "</p></td><td>";
                        $string = str_replace("</td><td><td><p>", "<p>", $string);
                    } else {
                        $string .= "<p>" . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . "</p>";
                    }
                } else {
                    header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                }
            }
        }
        $string .= "</td><td>" . $resultat['iduser1'] . "</td><td>" . $resultat['iduser2']. "</td><td><p><a class='btn' href='validate?id=" . $resultat['id'] . "'>Mark as done</a></p></td></tr>";
    }
    $string .= "</table>";
    echo $string;
} else {
    header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
}
?>
</body>
</html>