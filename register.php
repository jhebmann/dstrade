<?php
$loginexistant = FALSE;
$mailexistant = FALSE;
$passtropcourt = FALSE;
$login = "";
$mail = "";
$pass = "";
$max = 1;
if (isset($_POST['btn-signup'])) {
    $login = $_POST['login'];
    $mail = $_POST['mail'];
    $passtropcourt = (strlen($_POST['pass']) < 8);
    $pass = $_POST['pass'];

    include('cookie.php');

    $sql = "SELECT * FROM USERS WHERE USERNAME = '" . $login . "';";
    $requete = $bdd->query($sql);
    if ($requete != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $loginexistant = TRUE;
        }
    } else {
        print("There was a problem receiving informations from the database");
    }
    $sql = "SELECT * FROM USERS WHERE EMAIL = '" . $mail . "';";
    $requete = $bdd->query($sql);
    if ($requete != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $mailexistant = TRUE;
        }
    } else {
        print("There was a problem receiving informations from the database");
    }
    if (!$mailexistant && !$loginexistant && !$passtropcourt) {
        $sql = "SELECT max(id) FROM USERS";
        $requete = $bdd->query($sql);
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        $max = $resultats[0]['max'] + 1;

        $sql = "INSERT INTO USERS VALUES (" . $max . ",'" . $login . "', '" . password_hash($pass, PASSWORD_BCRYPT) . "', '" . $mail . "', current_timestamp, 0, 200);";
        $requete = $bdd->query($sql);
        if ($requete != FALSE) {
            header('Location: login?l=' . $login . '');
        } else {
            print("There was a problem receiving informations from the database");
        }
    }
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>DSTrade</title>
</head>
<body>
<form method="post">
    <table>
        <tr>
            <td>
                <div <?php if ($loginexistant) echo 'class="existant"'; ?> >
                    Login <?php if ($loginexistant) echo 'already exists !'; ?> </div>
                <input <?php if ($loginexistant) echo 'class="existant"';
                echo "value='" . $login . "'" ?> type="text" name="login"
                                                 placeholder="Login" required/></td>
        </tr>
        <tr>
            <td>
                <div <?php if ($mailexistant) echo 'class="existant"'; ?> >
                    Email <?php if ($mailexistant) echo 'already exists !'; ?> </div>
                <input <?php if ($mailexistant) echo 'class="existant"';
                echo "value='" . $mail . "'" ?> type="email" name="mail" placeholder="Email"
                                                required/></td>
        </tr>
        <tr>
            <td>
                <div <?php if ($passtropcourt) echo 'class="existant"'; ?> >
                    Password <?php if ($passtropcourt) echo 'too short (must be at least 8 characters) !'; ?> </div>
                <input type="password" name="pass" placeholder="Password" required/></td>
        </tr>
        <tr>
            <td>
                <button type="submit" name="btn-signup">Sign Up</button>
            </td>
        </tr>
        <tr>
            <td><a href="login">Log in here</a></td>
        </tr>
    </table>
</form>
</body>
</html>