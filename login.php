<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="icon" href="lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
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

include('includes/cookie.php');

if (!$connected) {
    $login = "";
    if (isset($_GET['l'])) {
        $login = $_GET['l'];
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
                        header('Location: error?src=' . $_SERVER['REQUEST_URI']);
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
                                header('Location: error?src=' . $_SERVER['REQUEST_URI']);
                            }
                        } else {
                            print("Wrong password !");
                        }
                    } else {
                        print("This Username/Email isn't registered yet !");
                    }
                } else {
                    header('Location: error?src=' . $_SERVER['REQUEST_URI']);
                }
            }
        } else {
            header('Location: error?src=' . $_SERVER['REQUEST_URI']);
        }
    }
    ?>
    <body>
    <?php include('includes/menu.php'); ?>
    <div id="cookies_banner">
        <p>By logging in, you accept to use cookies on this website.</p>
    </div>
    <h1>Log in</h1>
    <form method="post">
        <table class="no-border">
            <tr>
                <td>
                    <div>Login or email</div>
                    <input value="<?php print($login); ?>" type="text" name="loginOrMail" placeholder="Login or Mail"
                           required maxlength="50" />
                </td>
            </tr>
            <tr>
                <td>
                    <div>Password</div>
                    <input type="password" name="pass" placeholder="Password" required maxlength="50"/>
                </td>
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
    </body>
    </html>
    <?php
} else {
        header('Location: profile/infos');
}