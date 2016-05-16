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
<h1>Browse trade offers</h1>
<div class="center">
    <p>You can search for a specific item <a href="search">Here</a></p>
</div>
<?php
$sql = "";
if ($connected) {
    $sql = "SELECT * FROM TRADE WHERE STATE = 'OFFER' AND IDUSER1<>" . $user_infos['id'] . " ORDER BY ID DESC;";
} else {
    $sql = "SELECT * FROM TRADE WHERE STATE = 'OFFER' ORDER BY ID DESC;";
}
$string = "";
if (($requete = $bdd->query($sql)) != FALSE) {
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    $string .= "<table><tr><th>Offered items</th><th>Wanted items</th><th></th></tr>";
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
        if ($connected) {
            $string .= "</td><td><p><a class='btn' href='accept?id=" . $resultat['id'] . "'>ACCEPT</a></p></td></tr>";
        } else {
            $string .= "</td><td><p>You must be logged in to accept a trade offer !</p><p>Log in <a href='../login'>Here</a></p></td></tr>";
        }
    }
    $string .= "</table>";
    echo $string;
} else {
    header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
}
?>
</body>
</html>