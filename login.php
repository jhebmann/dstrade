<?php
function generateRandomString($length = 60)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

include('cookie.php');

$login = "";
if (isset($_GET['login'])) {
    $login = $_GET['login'];
}
if (isset($_POST['btn-login'])) {
    $login = $_POST['loginOrMail'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM USERS WHERE USERNAME='" . $login . "'";
    $requete = $bdd->query($sql);
    if ($requete != FALSE) {
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($resultats) != 0) {
            $resultat = $resultats[0];
            if (password_verify($pass, $resultat['pass'])) {
                $randomstring = generateRandomString();
                setcookie("token", $randomstring, time() + (3 * 3600), "/"); // 3*3600 = 3 hours
                $sql = "INSERT INTO SESSIONS VALUES ('" . $randomstring . "', " . $resultat['id'] . ", current_timestamp + interval '3 hours');";
                header('Location: .');
                $requete = $bdd->query($sql);
                if ($requete == FALSE) {
                    print("There was a problem receiving informations from the database");
                }
            } else {
                print("Wrong password !");
            }
        } else {
            $sql = "SELECT * FROM USERS WHERE email='" . $login . "'";
            $requete = $bdd->query($sql);
            if ($requete != FALSE) {
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($resultats) != 0) {
                    $resultat = $resultats[0];
                    if (password_verify($pass, $resultat['pass'])) {
                        $randomstring = generateRandomString();
                        setcookie("token", $randomstring, time() + (3 * 3600), "/"); // 3*3600 = 3 hours
                        $sql = "INSERT INTO SESSIONS VALUES ('" . $randomstring . "', " . $resultat['id'] . ", current_timestamp + interval '3 hours')";
                        header('Location: .');
                        $requete = $bdd->query($sql);
                        if ($requete == FALSE) {
                            print("There was a problem receiving informations from the database");
                        }
                    } else {
                        print("Wrong password !");
                    }
                } else {
                    print("This Username/Email isn't registered yet !");
                }
            } else {
                print("There was a problem receiving informations from the database");
            }
        }
    } else {
        print("There was a problem receiving informations from the database");
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
                <div>Login or email</div>
                <input value="<?php print($login); ?>" type="text" name="loginOrMail" placeholder="Login or Mail"
                       required/></td>
        </tr>
        <tr>
            <td>
                <div>Password</div>
                <input type="password" name="pass" placeholder="Password" required/></td>
        </tr>
        <tr>
            <td>
                <button type="submit" name="btn-login">Log In</button>
            </td>
        </tr>
        <tr>
            <td><a href="register">Register here</a></td>
        </tr>
    </table>
</form>
<a href="logout">Log out</a>
</body>
</html>