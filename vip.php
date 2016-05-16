<?php
include('includes/cookie.php');
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="icon" href="lib/favicon.png" type="image/png" sizes="32x32">
    <title>Vip levels</title>
</head>
<body>
<?php include('includes/menu.php'); ?>
<h1>Vip levels</h1>
<?php
if ($connected){
    $sql = "SELECT lvl, reduction, points_max from vip where " . $user_infos['vipoints'] . ">=points_min AND " . $user_infos['vipoints'] . "<points_max;";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        $resultat = $resultats[0];
        print("<div class='center'><p>You have " . $user_infos['vipoints'] . " vipoints, which means your vip level is " . $resultat['lvl'] . ", your reduction is of " . $resultat['reduction'] . "% and you need " . ($resultat['points_max']-$user_infos['vipoints']+1) . " points to lvl up !</p></div>");
    } else {
        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
    }
}
$sql = "SELECT * FROM vip";
if (($requete = $bdd->query($sql)) != FALSE) {
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    print("<table><tr><th>Vip level</th><th>Vipoints min</th><th>Vipoints max</th><th>Discount</th></tr>");
    foreach($resultats as $resultat){
        print("<tr><td>" . $resultat['lvl'] . "</td><td>" . $resultat['points_min'] . "</td><td>" . $resultat['points_max'] . "</td><td>" . $resultat['reduction'] . "%</td></tr>");
    }
    print("</table>");
} else {
    header('Location: error?src=' . $_SERVER['REQUEST_URI']);
}
?>
</body>
</html>