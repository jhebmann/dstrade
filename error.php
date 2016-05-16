<?php
include('includes/cookie.php'); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="icon" href="lib/favicon.png" type="image/png" sizes="32x32">
    <title>DSTrade</title>
</head>
<body>
<?php include('includes/menu.php'); ?>
<h1>ERROR</h1>
<div class="center"><p>There was a problem contacting the database !</p>
    <p>You may have enter incorrect or too long informations !</p>
    <p>Click <a href="<?php if(isset($_GET['src'])) print($_GET['src']); ?>">Here</a> to go back to your previous page.</p></div>
<?php
?>
</body>