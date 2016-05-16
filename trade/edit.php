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
<h1>Edit trade offer</h1>
<?php include('../includes/menu.php');
$gooduser = FALSE;
if (!$connected || !isset($_GET['id'])) {
    header('Location: ..');
} else {
    $sql = "SELECT * FROM TRADE WHERE ID=" . $_GET['id'] . "AND IDUSER1 = " . $user_infos['id'] . ";";
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
if (isset($_POST['btn-edit'])) {
    $update = "";
    foreach ($_POST['item_id1'] as $key => $value) {
        $update .= "IDITEM1_" . ($key + 1) . "=" . $value . ", QUANTITY1_" . ($key + 1) . "=" . $_POST['item_quantity1'][$key] . ", ";
    }
    foreach ($_POST['item_id2'] as $key => $value) {
        $update .= "IDITEM2_" . ($key + 1) . "=" . $value . ", QUANTITY2_" . ($key + 1) . "=" . $_POST['item_quantity2'][$key] . ", ";
    }
    $update = rtrim($update, ", ");
    $sql = "UPDATE TRADE SET " . $update . " WHERE ID=" . $_GET['id'] . ";";
    if (($requete = $bdd->query($sql)) != FALSE) {
        header("location:../profile/infos");
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
} else {
    $select = "<select name='item_id1[]'>";
    $sql = "SELECT ID, NAME FROM ITEM;";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultats as $key => $resultat) {
            $select .= "<option value='" . $resultat['id'] . "'>" . $resultat['name'] . "</option>";
        }
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
    $select .= "</select><input type='number' min='0' max='999' value='' name='item_quantity1[]'/>";

    $previous = "";
    $string = "<form method='post'><table class=\"no-border\"><tr><th>You're offering :</th><th>You're searching for :</th></tr><tr><td>";

    $sql = "SELECT * FROM TRADE WHERE id=" . $_GET['id'] . ";";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultats as $resultat) {
            $ids = ['iditem1_1', 'iditem1_2', 'iditem1_3', 'iditem2_1', 'iditem2_2', 'iditem2_3'];
            $quantities = ['quantity1_1', 'quantity1_2', 'quantity1_3', 'quantity2_1', 'quantity2_2', 'quantity2_3'];
            foreach ($ids as $key => $id) {
                if ($resultat[$id] != NULL) {
                    $sql = "SELECT NAME FROM ITEM WHERE ID = " . $resultat[$id] . ";";
                    if (($requete = $bdd->query($sql)) != FALSE) {
                        $resultats2 = $requete->fetchAll(PDO::FETCH_ASSOC);
                        $select = str_replace("value='" . $resultat[$id] . "'", "value='" . $resultat[$id] . "' selected='selected'", $select);
                        $select = str_replace("value='" . $previous . "'", "value='" . $resultat[$quantities[$key]] . "'", $select);
                        $previous = $resultat[$quantities[$key]];
                        if ($key < 3) {
                            $select = str_replace("2[]", "1[]", $select);
                            $string .= "<p>" . $select . "</p></td><td>";
                            $string = str_replace("</td><td><p>", "<p>", $string);
                        } else {
                            $select = str_replace("1[]", "2[]", $select);
                            $string .= "<p>" . $select . "</p>";
                        }
                    } else {
                        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                    }
                }
            }
            $string .= "</td></tr>";
        }
        $string .= "<tr><td colspan='2'><button type='submit' name='btn-edit'>Save</button></td></tr></table><input name='id' type='hidden' value='" . $_GET['id'] . "' /></form>";
        echo $string;
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
</body>
</html>
