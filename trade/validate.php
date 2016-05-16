<?php
include('../includes/cookie.php');
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <link rel="icon" href="../lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
<body>
<h1>Accept a trade offer</h1>
<?php include('../includes/menu.php');
if (!$connected  || $user_infos['role'] != "ADMIN" || !isset($_GET['id'])) {
    header('Location: ..');
} else {
    $sql = "UPDATE TRADE SET STATE='VALIDATED' WHERE ID=" . $_GET['id'] . ";";
    if (($requete = $bdd->query($sql)) == FALSE) {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
<div class="center"><p class="successful">This trade has successfully been validated !</p></div>
</body>
</html>