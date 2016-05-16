<?php
include('../includes/cookie.php');
$loginexistant = FALSE;
$wrongpass = FALSE;
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
    </body>
    <?php
} else {
    if (isset($_POST['btn-edit'])) {
        if (password_verify($_POST['pass'], $user_infos['pass'])) {
            if ($_POST['login'] != $user_infos['username']) {
                $sql = "SELECT * FROM USERS WHERE USERNAME = '" . $_POST['login'] . "';";
                $requete = $bdd->query($sql);
                if ($requete != FALSE) {
                    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($resultats) != 0) {
                        $loginexistant = TRUE;
                    }
                } else {
                    header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                }
            }
            if (!$loginexistant) {
                if ($_POST['steamid'] != NULL) {
                    if ($_POST['newpass'] != NULL) {
                        $sql = "UPDATE USERS SET USERNAME = '" . $_POST['login'] . "', STEAM64ID = '" . $_POST['steamid'] . "', PASS = '" . password_hash($_POST['newpass'], PASSWORD_BCRYPT) . "' WHERE ID = " . $user_infos['id'] . ";";
                    } else {
                        $sql = "UPDATE USERS SET USERNAME = '" . $_POST['login'] . "', STEAM64ID = '" . $_POST['steamid'] . "' WHERE ID = " . $user_infos['id'] . ";";
                    }
                } else if ($_POST['newpass'] != NULL) {
                    $sql = "UPDATE USERS SET USERNAME = '" . $_POST['login'] . "', PASS = '" . password_hash($_POST['newpass'], PASSWORD_BCRYPT) . "' WHERE ID = " . $user_infos['id'] . ";";
                } else{
                    $sql = "UPDATE USERS SET USERNAME = '" . $_POST['login'] . "' WHERE ID = " . $user_infos['id'] . ";";
                }
                $requete = $bdd->query($sql);
                if ($requete == FALSE) {
                    header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                } else{
                    header('Location: infos');
                }
            }
        }else{
            $wrongpass = TRUE;
        }
    }
    ?>
    <h1>Edit profile</h1>
    <form method="post">
        <table class="no-border">
            <tr>
                <td>
                    <div <?php if ($loginexistant) echo 'class="existant"'; ?> >
                        Login <?php if ($loginexistant) echo 'already exists !'; ?> </div>
                    <input value="<?php print($user_infos['username']); ?>" type="text" name="login"
                           placeholder="Login" required maxlength="50"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div>Steam64 ID</div>
                    <input value="<?php print($user_infos['steam64id']); ?>" type="text" name="steamid"
                           placeholder="Steam64 ID" maxlength="17" minlength="17"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div>New Password</div>
                    <input type="password" name="newpass" placeholder="New Password"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div <?php if ($wrongpass) echo 'class="existant"'; ?> >
                        Current Password <?php if ($wrongpass) echo 'is not correct'; ?> </div>
                    <input <?php if ($wrongpass) echo 'class="existant"'; ?>  type="password" name="pass" placeholder="Current Password" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="btn-edit">Save</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
