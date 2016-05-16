<?php
include('../includes/cookie.php');
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <link rel="icon" href="../lib/favicon.png" type="image/png" sizes="32x32">
    <title>Edit profile</title>
</head>
<body>
<?php include('../includes/menu.php');
if (!$connected) { ?>
    <h1>~ DSTrade ~</h1>
    <p>You're not logged in !</p>
    <p>Log in <a href="../login">Here</a> or register <a href="../register">Here</a> !</p>
<?php
} else {
if (isset($_POST['btn-edit'])) {
    $sql = "UPDATE USERS SET SL = " . $_POST['sl'] . "WHERE ID = " . $user_infos['id'] . ";";
    if (($requete = $bdd->query($sql)) == FALSE) {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }

    /*
    $sql = "SELECT * FROM ITEM, POSSESS WHERE id = id_item and id_user = " . $user_infos['id'] . ";";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach ($_POST['item'] as $key => $item) {
            $sql = "UPDATE POSSESS SET QUANTITY = " . $item . " WHERE ID_USER = " . $user_infos['id'] . " AND ID_ITEM = " . $resultats[$key]['id_item'] . ";";
            if (($requete = $bdd->query($sql)) == FALSE) {
                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
            }
        }
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
    $quantities = Array();
    $ids = Array();
    foreach ($_POST['new_item_id'] as $key => $val) {
        if (!isset($ids[$val])) {
            $quantities[$_POST['new_item_quantity'][$key]] = true;
        }
        $ids[$val] = true;
    }
    $quantities = array_keys($quantities);
    $ids = array_keys($ids);

    foreach ($ids as $key => $val) {
        $sql = "INSERT INTO POSSESS VALUES (" . $user_infos['id'] . ", " . $val . ", " . $quantities[$key] . ");";
        if (($requete = $bdd->query($sql)) == FALSE) {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }
    }

    $sql = "DELETE FROM POSSESS WHERE QUANTITY = 0";
    if (($requete = $bdd->query($sql)) == FALSE) {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
    */

    header('Location: infos');
}
?>
    <h1>Edit character</h1>
    <form method="post">
        <table class="no-border">
            <tr>
                <td>
                    <div>Soul level</div>
                    <input type="number" min="1" max="713" name="sl" placeholder="Soul level"
                           value="<?php echo $user_infos['sl']; ?>" required/>
                </td>
            </tr>

            <?php
            /*
            <tr>
                <td>
                    <div>Items</div>
                </td>
            </tr>
            <?php
            $sql = "SELECT * FROM ITEM, POSSESS WHERE id = id_item and id_user = " . $user_infos['id'] . ";";
            if (($requete = $bdd->query($sql)) != FALSE) {
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultats as $key => $result) {
                    print("
                        <tr>
                            <td>
                                <div>" . $result['name'] . "</div>
                                <input type='number' min='0' max='999' name='item[" . $key . "]' placeholder='Quantity' value='" . $result['quantity'] . "'/>
                            </td>
                        </tr>
                        ");
                }
            } else {
                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
            }
            ?>
            <tr>
                <td>
                    <button type="button" id="add_item">Add</button>
                </td>
            </tr>
            */
            ?>
            
            <?php

            /*
            $select = "<select name='new_item_id[]'>";
            $sql = "SELECT ID, NAME FROM ITEM;";
            if (($requete = $bdd->query($sql)) != FALSE) {
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultats as $key => $resultat) {
                    $select .= "<option value='" . $resultat['id'] . "'>" . $resultat['name'] . "</option>";
                }
            } else {
                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
            }
            $select .= "</select><input type='number' min='0' max='999' value='' name='new_item_quantity[]'/>";


            $string = "<tr><td><div>Trade offers :</div></td></tr>";
            $sql = "SELECT * FROM TRADE WHERE IDUSER1 = " . $user_infos['id'] . ";";
            $previous = "";
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
                                $select = str_replace("value='" . $resultat[$id] ."'", "value='" . $resultat[$id] ."' selected='selected'", $select);
                                $select = str_replace("value='" . $previous ."'", "value='" . $resultat[$quantities[$key]] ."'", $select);
                                $previous = $resultat[$quantities[$key]];
                                if ($key < 3) {
                                    $string .= "<tr><td>You're offering : " . $select ." ; </td>";
                                    $string = str_replace(" ; </td><tr><td>You're offering : ", ", </td><td>", $string);
                                } else {
                                    $string .= "<td>You're searching for : " . $select .", </td>";
                                    $string = str_replace(", </td><td>You're searching for : ", ", </td><td>", $string);
                                }
                            } else {
                                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                            }
                        }
                    }
                    $string = rtrim($string, ", </td><td>");
                    $string.="</td></tr>";
                }
            } else {
                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
            }
            echo $string;

            */
            ?>

            <tr>
                <td>
                    <button type="submit" name="btn-edit">Save</button>
                </td>
            </tr>
        </table>
    </form>

<?php
/*
    <script>
        <?php
        $tr = "<tr><td><select name='new_item_id[]'>";
        $sql = "SELECT ID, NAME FROM ITEM WHERE ID NOT IN (SELECT ID_ITEM FROM POSSESS WHERE ID_USER = " . $user_infos['id'] . ");";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultats as $key => $resultat) {
                $tr .= "<option value='" . $resultat['id'] . "'>" . $resultat['name'] . "</option>";
            }
        } else {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }
        $tr .= "</select></td><td><input type='number' min='0' max='999' value='0' name='new_item_quantity[]'/></td></tr>";
        ?>
        $("#add_item").click(function () {
            $(this).parent().parent().before("<?php print($tr); ?>");
        });
    </script>
*/
?>

    <?php
}
?>
</body>
</html>
