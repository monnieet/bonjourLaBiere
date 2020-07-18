<?php

// Connect to database
require_once('../connectBdd.php');

// Check 'id' input
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];

	// Query to delete row located at 'id'
	$query = $db->prepare('DELETE FROM images_bieres WHERE ID=:id;');
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();

	// Back to admin space
	header('Location: ../affichageBdd.php');
}

// Disconnect from database
require_once('../deconnectBdd.php');
?>
