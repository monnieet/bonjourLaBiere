<?php 

// Connect to database
require_once('../connectBdd.php');

if (isset($_POST)) {
	if (isset($_POST['desc']) && !empty($_POST['desc'])
		&& !empty($_FILES['imageFile']['name'])) {
 
		$Description = $_POST['desc'];
		// This variable is an hidden input (true for admin access, false for suggestion)
		$Approved = $_POST['approv'];

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

			// Insert new row into the database
			$query = $db->prepare("INSERT INTO `images_bieres`(`Img`, `Description`, `Approved`) VALUES (:Img,:Description,:Approved)");
			$query->bindValue(':Img', $Img, PDO::PARAM_LOB);
			$query->bindValue(':Description', $Description, PDO::PARAM_STR);
			$query->bindValue(':Approved', $Approved, PDO::PARAM_BOOL);
			$query->execute();

			// Back to either suggestion or admin page
			if ($Approved) {
				header('Location: ../affichageBdd.php');
			} else {
				header('Location: ../../suggestion.php?suggestionEnvoyee=1');
			}
		}
	}
}

// Disconnect from database
require_once('../deconnectBdd.php');

?>


<!DOCTYPE html>
<html>
	<head>
		<title>INSERT</title>
		<meta charset="utf-8">
	</head>

	<body>
		<form action="add.php" method="post" enctype="multipart/form-data">
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
				<label for="imageFile">Load Image: </label>
				<input type="file" name="imageFile" id="imageFile">
				<br />
				<label for="desc">Describe the image: (author, theme...)</label>
				<br />
				<textarea name="desc" id="desc" rows="8" cols="45"></textarea>
				<br />
				<button>Insérer</button>
				<input type="hidden" name="approv" id="approv" value=1>
			</p>
		</form>
		<p><br /><a href="../affichageBdd.php">CANCEL</a></p>
	</body>
</html>