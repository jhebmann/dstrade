<?php
include('includes/cookie.php');
if (!$connected) {
    header('Location: .');
}
$reduction = 0;
$sql = "SELECT REDUCTION FROM VIP WHERE " . $user_infos['vipoints'] . "<=points_max AND " . $user_infos['vipoints'] . ">=points_min";
if (($requete = $bdd->query($sql)) != FALSE) {
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    $reduction = $resultats[0]['reduction'];
} else {
    header('Location: error?src=' . $_SERVER['REQUEST_URI']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    
    <link rel="icon" href="lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
<body>
<?php include('includes/menu.php'); ?>
<h1>Buy items with souls</h1>
<?php if (isset($_POST['btn-buy'])) {
    $sql = "SELECT buy_item(" . $user_infos['id'] . ", " . $_POST['item'] . ", " . $_POST['quantity'] . ", " . $_POST['total_cost'] . ");";
    if (($requete = $bdd->query($sql)) != FALSE) {
        $sql = "SELECT NAME FROM ITEM WHERE ID=" . $_POST['item'] . ";";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            print("<div class='successful center'><p>You successfully bought " . $_POST['quantity'] . " " . $resultats[0]['name'] . " for " . $_POST['total_cost'] . " souls !</p></div>");
        } else {
            header('Location: error?src=' . $_SERVER['REQUEST_URI']);
        }
    } else {
        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
<div class="center"><p>You have <span
            id="souls"><?php if (!isset($_POST['btn-buy'])) echo $user_infos['souls']; else echo $user_infos['souls'] - $_POST['total_cost']; ?></span>
        souls, you can buy more <a
            href="buy">Here</a></p>
    <p>You have <?php echo $user_infos['vipoints']; ?> vipoints, so you have a <?php echo $reduction; ?>% discount
        (prices are taking this in account) !</p></div>
<form method="post">
    <table class="no-border">
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
                        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
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
                    $costs = "";
                    $stocks = "";
                    $sql = "SELECT ID, NAME, TYPE, QUANTITY, PRICE FROM ITEM ORDER BY NAME ASC;";
                    if (($requete = $bdd->query($sql)) != FALSE) {
                        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($resultats as $key => $resultat) {
                            $costs .= "<span class='" . $resultat['id'] . "'>" . floor($resultat['price'] * (1 - $reduction / 100)) . "</span>";
                            $stocks .= "<span class='" . $resultat['id'] . "'>" . $resultat['quantity'] . "</span>";
                            $selected = "";
                            if (isset($_POST['btn-search'])) {
                                if ($_POST['item'] == $resultat['id']) {
                                    $selected = "selected";
                                }
                            }
                            print("<option value='" . $resultat['id'] . "' class='" . str_replace(' ', '', $resultat['type']) . " ANY' " . $selected . ">" . $resultat['name'] . "</option>");
                        }
                    } else {
                        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <p>In stock : <span id="stock"><?php echo $stocks; ?></span></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Cost : <span id="cost"><?php echo $costs; ?></span></p>
            </td>
        </tr>
        <tr>
            <td>
                Quantity :
                <input id="quantity" name="quantity" type="number" value="1" placeholder="Quantity" min="1" max="999"/>
            </td>
        </tr>
        <tr>
            <td>
                <p>Total cost : <span id="total_cost"></span></p>
                <input id="totalcost" name="total_cost" type="hidden"/>
            </td>
        </tr>
        <tr>
            <td>
                <button type='submit' name='btn-buy' id="rich">Buy</button>
                <p id="poor">You don't have enough souls to buy that ! You can buy them <a href="buy">Here</a></p>
            </td>
        </tr>
    </table>
</form>
<script>
    $(document).ready(function () {
        $('#select_type').trigger("change");
    });

    $("#select_type").change(function () {
        if ($(this).data('options') == undefined) {
            $(this).data('options', $('#select_item option').clone());
        }
        var type = $(this).val();
        var options = $(this).data('options').filter('.' + type);
        $('#select_item').html(options);
        $('#select_item option:eq(0)').prop('selected', true);
        $('#select_item').trigger("change");
    });

    $("#quantity").change(function () {
        $('#select_item').trigger("change");
    });

    $("#select_item").change(function () {
        if ($(this).data('stocks') == undefined) {
            $(this).data('stocks', $('#stock span').clone());
        }
        var id = $(this).val();
        var stocks = $(this).data('stocks').filter('.' + id);
        $('#stock').html(stocks);

        if ($(this).data('costs') == undefined) {
            $(this).data('costs', $('#cost span').clone());
        }
        var costs = $(this).data('costs').filter('.' + id);
        $('#cost').html(costs);

        var quantity = parseInt($("#quantity").val());
        var cost = parseInt($("#cost").text());
        $("#total_cost").html(quantity * cost);
        $("#totalcost").val(quantity * cost);

        $("#quantity").attr({"max": $("#stock").text()});

        if (parseInt($("#souls").text()) > parseInt($("#total_cost").text())) {
            $("#poor").hide(0);
            $("#rich").show(0);
        } else {
            $("#rich").hide(0);
            $("#poor").show(0);
        }
    });
</script>
</body>
</html>