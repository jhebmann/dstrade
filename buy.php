<?php
include('includes/cookie.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    
    <link rel="icon" href="lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
<body>
<?php
include('includes/menu.php');
?>
<h1>Buy souls</h1>
<?php
if (isset($_POST['btn-buy'])) {
    $sql = "UPDATE USERS SET SOULS = SOULS + " . $_POST['souls'] . ", VIPOINTS = VIPOINTS + " . ($_POST['souls'] / 100) . " WHERE ID=" . $user_infos['id'] . ";";
    if (($requete = $bdd->query($sql)) != FALSE) {
        print("<div class='center successful'><p>You successfully bought " . $_POST['souls'] . " souls and also got " . ($_POST['souls'] / 100) . " vipoints</p></div>");
    } else {
        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
    }
}
?>
<div class="center"><p>Thank you for giving us up to an hour to validate your payment.</p></div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="6DL6WNJ7MCU64">
    <table class="no-border">
        <tr>
            <td><input type="hidden" name="on0" value="Souls">Souls</td>
        </tr>
        <tr>
            <td><select name="os0">
                    <option value="1000 souls">1000 souls & 10 Vipoints €2,00 EUR</option>
                    <option value="4000 souls">4000 souls & 40 Vipoints €5,00 EUR</option>
                    <option value="10000 souls">10000 souls & 100 Vipoints €10,00 EUR</option>
                    <option value="25000 souls">25000 souls & 250 Vipoints €20,00 EUR</option>
                    <option value="70000 souls">70000 souls & 700 Vipoints €25,00 EUR</option>
                </select></td>
        </tr>
    </table>
    <input type="hidden" name="currency_code" value="EUR">
    <div class="center">
        <input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif" border="0"
               name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
        <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
    </div>
</form>
<div class="center"><p>For testing purpose, here is a free version !</p></div>
<form method="post">
    <table class="no-border">
        <tr>
            <td>
                <select name="souls">
                    <option value="1000">1000 souls & 10 Vipoints €00,00 EUR</option>
                    <option value="4000">4000 souls & 40 Vipoints €00,00 EUR</option>
                    <option value="10000">10000 souls & 100 Vipoints €00,00 EUR</option>
                    <option value="25000">25000 souls & 250 Vipoints €00,00 EUR</option>
                    <option value="70000">70000 souls & 700 Vipoints €00,00 EUR</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" name="btn-buy">Get for free</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>