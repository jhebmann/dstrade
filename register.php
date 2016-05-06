<?php
if (isset($_POST['btn-signup'])) {
    $login = $_POST['login'];
    $mail = $_POST['mail'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);

    include('connexion.php');

    $sql='SELECT * FROM USERS;';
    $requete = $bdd->query($sql);
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    print_r($resultats);
}
?>
<html>
<head>
    <title>DSTrade</title>
</head>
<body>
<form method="post">
    <table>
        <tr>
            <td>
                <div>Login</div>
                <input type="text" name="login" placeholder="Login" required/></td>
        </tr>
        <tr>
            <td>
                <div>Email</div>
                <input type="email" name="mail" placeholder="Email" required/></td>
        </tr>
        <tr>
            <td>
                <div>Password</div>
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