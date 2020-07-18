<?php 

// Start session to set $_SESSION if authentification succeeded
session_start();

// Check login and password
if (isset($_POST['login']) && isset($_POST['mdp'])) {
	$username = htmlspecialchars($_POST['login']); 
    $password = htmlspecialchars($_POST['mdp']);

    if($username == "admin" && $password == "lezard") {
    	$_SESSION['access'] = True;
    } else {
    	header("Location: deconnexionAdmin.php");
    }
}

// Connect to database
require_once('connectBdd.php');

$response = $db->query("SELECT * FROM images_bieres");

// Disconnect from database
require_once('deconnectBdd.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Espace Admin</title>
		<meta charset="utf-8">
	</head>

	<body>
		<?php 
			// Check access
			if (!empty($_SESSION['access'])) {
		?>
					<h1>Espace Admin</h1>
					<p>
						<a href="deconnexionAdmin.php">Déconnexion</a>
						<br />
						<br />
						<a href="./crud/add.php">Add</a>
						<br />
						<a href="approvingPage.php">Photos en attentes</a>
					</p>
					<h3>Liste des bières:</h3>
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
								while ($biere = $response->fetch()) {
							?>
									<tr>
										<td><?= $biere['ID'] ?></td>
										<td><img src="<?=$biere['Img']?>" width='150' height='150'/></td>
										<td><?= $biere['Description'] ?></td>
										<td><?= $biere['Approved'] ?></td>
										<td><?= $biere['Online'] ?></td>
										<td><?= $biere['Date'] ?></td>
										<td><a href="./crud/read.php?id=<?= $biere['ID'] ?>">Read</a>  
											<a href="./crud/edit.php?id=<?= $biere['ID'] ?>">Edit</a> 
											<a href="./crud/delete.php?id=<?= $biere['ID'] ?>">Delete</a></td>
									</tr>
							<?php
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