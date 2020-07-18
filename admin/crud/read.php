<?php 

// Connect to database
require_once('../connectBdd.php');

// Check 'id' to read the appropriate row in the database
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	$query = $db->prepare('SELECT * FROM images_bieres WHERE ID=:id');
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();

	// Row at 'id', variable will be used to display elements
	$biere = $query->fetch();
}

// Disconnect from database
require_once('../deconnectBdd.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Read</title>
		<meta charset="utf-8">
	</head>

	<body>
		<h1>Détails de l'image:</h1>
		<p><a href="edit.php?id=<?= $biere['ID'] ?>">Edit</a>  
			<a href="delete.php?id=<?= $biere['ID'] ?>">Delete</a>
			<a href="../affichageBdd.php">Back to Admin Space</a></p>
		<p>ID : <?=$biere['ID'] ?></p>
		<p><img src="<?=$biere['Img']?>" width='30%' height='30%'/></p>
		<p>Description : <?=$biere['Description'] ?></p>
		<p>Approved : <?php if ($biere['Approved']) {?> Oui <?php } else { ?> En attente <?php } ?></p>
		<p>Statut : <?php if ($biere['Online']) { ?> Mise en ligne le <?=$biere['Date'] ?> <?php } else { ?> En attente de mise en ligne <?php }?> </p>
	</body>
</html>