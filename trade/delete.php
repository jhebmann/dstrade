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
<h1>Delete trade offer</h1>
<?php include('../includes/menu.php');
$gooduser = FALSE;
if (!$connected || !isset($_GET['id'])) {
    header('Location: ..');
} else {
    $sql = "SELECT * FROM TRADE WHERE ID=" . $_GET['id'] . "AND IDUSER1 = " . $user_infos['id'] . " AND STATE='OFFER';";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $gooduser = TRUE;
        }
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
}
if (!$gooduser) {
    header('Location: ..');
}
if (isset($_POST['btn-delete'])) {
    $sql = "DELETE FROM TRADE WHERE ID=" . $_GET['id'] . ";";
    if (($requete = $bdd->query($sql)) != FALSE) {
        header('Location: ../profile/infos');
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
<form method="post">
    <div class="center">
        <p>Are you sure to delete this trade ?</p>
        <button type='submit' name='btn-delete'>Delete</button>
    </div>
</form>
</body>
</html>