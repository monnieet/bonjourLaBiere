<?php

// Connect to database
require_once('../connectBdd.php');

if (isset($_POST)) {
		if (isset($_POST['desc'])
		&& isset($_POST['id']) && !empty($_POST['id'])
		&& isset($_POST['approv'])) {

			$id = $_POST['id'];
			$Approved = $_POST['approv'];
			$Description = $_POST['desc'];

			// Check if there is a picture to change
			if (!empty($_FILES['imageFile']['name'])) {

				// information concerning file to upload and location to store even if it is directly stored in database as base64
				$name = $_FILES['imageFile']['name'];
				$target_dir = "../../images/bieres/";
				$target_file = $target_dir . basename($_FILES["imageFile"]["name"]);

				// Select file type
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				// Valid file extensions for images
				$extensions_arr = array("jpg","jpeg","png","gif");

				// Check extension
				if( in_array($imageFileType,$extensions_arr) ){

					// Convert to base64 
					$image_base64 = base64_encode(file_get_contents($_FILES['imageFile']['tmp_name']) );
					$Img = 'data:image/'.$imageFileType.';base64,'.$image_base64;

					// Upload file to keep a track of images online
					move_uploaded_file($_FILES['imageFile']['tmp_name'],$target_dir.$name);

					// Insert changed row into the database
					$query = $db->prepare("UPDATE `images_bieres` SET `Img`=:Img, `Description`=:Description, `Approved`=:Approved WHERE `ID`=:id;");
					$query->bindValue(':Img', $Img, PDO::PARAM_LOB);
					$query->bindValue(':Approved', $Approved, PDO::PARAM_BOOL);
					$query->bindValue(':Description', $Description, PDO::PARAM_STR);
					$query->bindValue(':id', $id, PDO::PARAM_INT);
					$query->execute();
					
					// Back to admin space
					header('Location: ../affichageBdd.php');
				}
			} else {
				// Insert changed row into the database
				$query = $db->prepare("UPDATE `images_bieres` SET `Description`=:Description, `Approved`=:Approved WHERE `ID`=:id;");
				$query->bindValue(':Approved', $Approved, PDO::PARAM_BOOL);
				$query->bindValue(':Description', $Description, PDO::PARAM_STR);
				$query->bindValue(':id', $id, PDO::PARAM_INT);
				$query->execute();

				// Back to admin space
				header('Location: ../affichageBdd.php');
			}
		}
	}


// Check 'id' and select the appropriate row
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	$query = $db->prepare('SELECT * FROM images_bieres WHERE ID=:id;');
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();

	// Response of beer at 'id' in the database, will be used for 'post' method
	$biere = $query->fetch();
}

// Disconnect from database
require_once('../deconnectBdd.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit</title>
		<meta charset="utf-8">
	</head>

	<body>
		<h1>Modifier une bière:</h1>
		<form action="edit.php" method="post" enctype="multipart/form-data">
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
				<label for="imageFile">Load image to substitute: </label>
				<input type="file" name="imageFile" id="imageFile">
				<br />
				<label for="desc">Describe the image: (author, theme...)</label>
				<br />
				<textarea name="desc" id="desc" rows="8" cols="45"><?= $biere['Description'] ?></textarea>
				<br />
				<label for="approv">Approuver ?</label>
				<input type="text" name="approv" value="<?= $biere['Approved'] ?>">
				<button>Enregistrer</button>
				<input type="hidden" name="id" value="<?= $biere['ID'] ?>">
			</p>
		</form>
		<p><br /><a href="../affichageBdd.php">CANCEL</a></p>
	</body>
</html>