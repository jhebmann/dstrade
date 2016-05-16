<?php
try {
	$host="";
	$port="";
	$dbname="";
	$user="";
	$password="";
    $bdd = new PDO('pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';user=' . $user . ';password=' . $password . '');
} catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}
?>