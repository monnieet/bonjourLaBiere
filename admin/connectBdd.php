<?php
try
{
	// Connect to MySQL database (Databasename 'bieres', username 'root' and password '' may be adapted to your own dataset)
	$db = new PDO('mysql:host=localhost;dbname=bieres;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	// If can't connect, display errors and exit
        die('Erreur : '.$e->getMessage());
}
?>