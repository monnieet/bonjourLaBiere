<?php 

// Recover $_SESSION variables to restrict access
session_start();

// Connect to database
require_once('connectBdd.php');

// Approved a beer in the database
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	$query = $db->prepare("UPDATE `images_bieres` SET `Approved`=True WHERE `ID`=:id;");
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();
}

// Read entire database
$response = $db->query('SELECT * FROM images_bieres');

// Disconnect from database
require_once('deconnectBdd.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Approving page</title>
		<meta charset="utf-8">
	</head>

	<body>
		<?php 

		// Restrict access
		if (!empty($_SESSION['access'])) {
		?>
			<h1>Liste des bières en attentes d'approbation:</h1>
			<a href="affichageBdd.php">Back to list</a>
			<table>
				<thead>
					<th>ID</th>
					<th>Img</th>
					<th>Description</th>
					<th>Approved</th>
					<th>Online</th>
					<th>Date</th>
					<th>Actions</th>
				</thead>
				<tbody>
					<?php 
						// Only recover beers that require validation
						while ($biere = $response->fetch()) {
							if ($biere['Approved']==False) {
					?>
								<tr>
									<td><?= $biere['ID'] ?></td>
									<td><img src="<?=$biere['Img']?>" width='150' height='150'/></td>
									<td><?= $biere['Description'] ?></td>
									<td><?= $biere['Approved'] ?></td>
									<td><?= $biere['Online'] ?></td>
									<td><?= $biere['Date'] ?></td>
									<td><a href="approvingPage.php?id=<?= $biere['ID'] ?>">Approve</a>  
										<a href="./crud/delete.php?id=<?= $biere['ID'] ?>">Reject</a></td>
								</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>	
		<?php 
		} else {
			// If fail with $_SESSION, back to homepage
			header("Location: ../home.php");
		}
		?>	
	</body>
</html>