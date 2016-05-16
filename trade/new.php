<?php
include('../includes/cookie.php');
if (!$connected) {
    header('Location: login');
}
if (isset($_POST['btn-submit'])) {
    $quantities1 = Array();
    $ids1 = Array();
    foreach ($_POST['item_id'] as $key => $val) {
        if (!isset($ids1[$val])) {
            $quantities1[$_POST['item_quantity'][$key]] = true;
        }
        $ids1[$val] = true;
    }
    //array slice pour eviter l'ajout de trop de valeurs
    $quantities1 = array_slice(array_keys($quantities1), 0, 3);
    $ids1 = array_slice(array_keys($ids1), 0, 3);

    $quantities2 = Array();
    $ids2 = Array();
    foreach ($_POST['new_item_id'] as $key => $val) {
        if (!isset($ids2[$val])) {
            $quantities2[$_POST['new_item_quantity'][$key]] = true;
        }
        $ids2[$val] = true;
    }
    $quantities2 = array_slice(array_keys($quantities2), 0, 3);
    $ids2 = array_slice(array_keys($ids2), 0, 3);

    $id = 1;
    $sql = "SELECT MAX(ID) FROM TRADE;";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats[0]['max']) != "") {
            $id = $resultats[0]['max'] + 1;
        }
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }


    $string = $id . ", " . $user_infos['id'] . ", ";
    for ($i = 0; $i < 3; $i++) {
        if (sizeof($ids1) > $i) {
            $string .= $ids1[$i] . ", " . $quantities1[$i] . ", ";
        } else {
            $string .= "NULL, 0, ";
        }
    }
    for ($i = 0; $i < 3; $i++) {
        if (sizeof($ids2) > $i) {
            $string .= $ids2[$i] . ", " . $quantities2[$i] . ", ";
        } else {
            $string .= "NULL, 0, ";
        }
    }
    $string.="'OFFER'";

    $sql = "INSERT INTO TRADE(ID, IDUSER1, IDITEM1_1, QUANTITY1_1, IDITEM1_2, QUANTITY1_2, IDITEM1_3, QUANTITY1_3, IDITEM2_1, QUANTITY2_1, IDITEM2_2, QUANTITY2_2, IDITEM2_3, QUANTITY2_3, STATE) VALUES(" . $string . ");";
    if (($requete = $bdd->query($sql)) == FALSE) {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    } else{
        header('Location: ../profile/infos');
    }
}
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
<h1>Create a trade offer</h1>
<form method="post">
    <div class="center">
        <p>Select the items you offer and the quantities of these items</p>
    </div>
    <table class="no-border">
        <?php
        /*
        $sql = "SELECT * FROM ITEM, POSSESS WHERE id = id_item and id_user = " . $user_infos['id'] . ";";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($resultats) == 0) {
                $noitems = TRUE;
            }
            foreach ($resultats as $resultat) {
                print("<tr><td><div>" . $resultat['name'] . " : </div><input type='hidden' name='item_id[]' value='" . $resultat['id'] . "' /><input name='item[]' type='number' min='0' value='0' max='" . $resultat['quantity'] . "' /></td></tr>");
            }
        } else {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }
        */
        $tr1 = "<tr><td><select name='item_id[]'>";
        $sql = "SELECT ID, NAME FROM ITEM;";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultats as $key => $resultat) {
                $tr1 .= "<option value='" . $resultat['id'] . "'>" . $resultat['name'] . "</option>";
            }
        } else {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }
        $tr1 .= "</select></td><td><input type='number' min='0' max='999' value='0' name='item_quantity[]'/></td></tr>";
        $tr2 = str_replace("item", "new_item", $tr1);
        print($tr1);
        ?>
        <tr>
            <td colspan="2">
                <button type="button" id="add_item">Add</button>
            </td>
        </tr>
    </table>
    <div class="center">
        <p>Select the items you want and the quantities of these items</p>
    </div>
    <table class="no-border">
        <?php
        print($tr2);
        ?>
        <tr>
            <td colspan="2">
                <button type="button" id="add_new_item">Add</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" name="btn-submit">Save</button>
            </td>
        </tr>
    </table>
</form>
<script>
    $("#add_item").click(function () {
        if ($('[name="item_id[]"]').size() < 3) {
            $(this).parent().parent().before("<?php print($tr1); ?>");
        }
        if ($('[name="item_id[]"]').size() == 3) {
            $('#add_item').hide();
        }
    });
    $("#add_new_item").click(function () {
        if ($('[name="new_item_id[]"]').size() < 3) {
            $(this).parent().parent().before("<?php print($tr2); ?>");
        }
        if ($('[name="new_item_id[]"]').size() == 3) {
            $('#add_new_item').hide();
        }
    });
</script>
</body>