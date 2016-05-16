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
<h1>Search for an item</h1>
<form method="post">
    <table class="no-border">
        <tr>
            <td>
                <input type="radio" name="type"
                       value="1"<?php if (!isset($_POST['btn-search']) || $_POST['type'] == 1) print("checked") ?>/>I
                want to get this item
                <input type="radio" name="type"
                       value="2"<?php if (isset($_POST['btn-search']) && $_POST['type'] == 2) print("checked") ?>/>I
                want to offer this item
            </td>
        </tr>
        <tr>
            <td>
                Item type :
                <select name="item_type" id="select_type">
                    <option value="ANY" selected>ANY</option>
                    <?php
                    $sql = "SELECT DISTINCT TYPE FROM ITEM ORDER BY TYPE ASC;";
                    if (($requete = $bdd->query($sql)) != FALSE) {
                        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($resultats as $key => $resultat) {
                            $selected = "";
                            if (isset($_POST['btn-search'])) {
                                if ($_POST['item_type'] == $resultat['type']) {
                                    $selected = "selected";
                                }
                            }
                            print("<option value='" . str_replace(' ', '', $resultat['type']) . "' " . $selected . ">" . $resultat['type'] . "</option>");
                        }
                    } else {
                        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Item :
                <select name="item" id="select_item">
                    <?php
                    $sql = "SELECT ID, NAME, TYPE FROM ITEM ORDER BY NAME ASC;";
                    if (($requete = $bdd->query($sql)) != FALSE) {
                        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($resultats as $key => $resultat) {
                            $selected = "";
                            if (isset($_POST['btn-search'])) {
                                if ($_POST['item'] == $resultat['id']) {
                                    $selected = "selected";
                                }
                            }
                            print("<option value='" . $resultat['id'] . "' class='" . str_replace(' ', '', $resultat['type']) . " ANY' " . $selected . ">" . $resultat['name'] . "</option>");
                        }
                    } else {
                        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Minimal quantity :
                <input name="quantity" type="number" value="<?php if(isset($_POST['btn-search'])) print($_POST['quantity']); else print("1"); ?>" placeholder="Quantity" min="1" max="999"/>
            </td>
        </tr>
        <tr>
            <td>
                <button type='submit' name='btn-search'>Search</button>
            </td>
        </tr>
    </table>
</form>
<?php
if (isset($_POST['btn-search'])) {
    $sql = "SELECT * FROM TRADE WHERE STATE = 'OFFER' AND ((IDITEM" . $_POST['type'] . "_1 = " . $_POST['item'] . " AND QUANTITY" . $_POST['type'] . "_1 >= " . $_POST['quantity'] . ") OR (IDITEM" . $_POST['type'] . "_2 = " . $_POST['item'] . " AND QUANTITY" . $_POST['type'] . "_2 >= " . $_POST['quantity'] . ") OR (IDITEM" . $_POST['type'] . "_3 = " . $_POST['item'] . " AND QUANTITY" . $_POST['type'] . "_3 >= " . $_POST['quantity'] . "));";
    $string = "";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) > 0) {
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
        } else {
            $string .= "<div class='center'><p>No result !</p></div>";
        }
        echo $string;
    } else {
        header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
<script>
    $("#select_type").change(function () {
        if ($(this).data('options') == undefined) {
            $(this).data('options', $('#select_item option').clone());
        }
        var type = $(this).val();
        var options = $(this).data('options').filter('.' + type);
        $('#select_item').html(options);
    });
    $(document).ready(function () {
        $('#select_type').trigger("change");
    });
</script>
</body>
</html>