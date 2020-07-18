<?php 

// Variable can notify user if its request has been properly sent
$suggestionEnvoyee = 0;

if (isset($_GET['suggestionEnvoyee']) && !empty($_GET['suggestionEnvoyee'])) {
	$suggestionEnvoyee = $_GET['suggestionEnvoyee'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bonjour la Biere</title>
	<link rel="stylesheet" type="text/css" href="./css/suggestion.css">
</head>

<body>

	<div id="bloc_page">

		<header>

			<div id="menu">
				<div id="nom"><h1>Bonjour la bière</h1></div>

				<nav>
					<ul>
						<li><a href="home.php">Accueil</a></li>
						<li><a href="aPropos.html">À propos</a></li>
						<li><a href="suggestion.php">Suggestion ?</a></li>
					</ul>
				</nav>
			</div>
			
		</header>

		<section id="suggestion">
			
			<h2>Suggestion:</h2>
			<form action="./admin/crud/add.php" method="post" enctype="multipart/form-data">
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
				<label for="imageFile">Load Image: </label>
				<input type="file" name="imageFile" id="imageFile">
				<br /><br />
				<label for="desc">Describe the image: (author, theme...)</label>
				<br />
				<textarea name="desc" id="desc" rows="8" cols="45"></textarea>
				<br /><br />
				<button>Suggérer</button>
				<input type="hidden" name="approv" id="approv" value=0>
			</p>
			</form>

			<?php 
			if ($suggestionEnvoyee) {
			?>
			<p>Merci pour votre suggestion ! Elle sera peut être affichée prochainement !</p>
			<?php
			}
			?>

		</section>
		
		<section id="adminLogin">
			<h3>Accès à l'espace admin:</h3>
			<form action="./admin/affichageBdd.php" method="post">
				<label for="login">Login:</label>
			  	<input type="text" id="login" name="login"><br>
			  	<label for="login">Password:</label>
			  	<input type="password" id="mdp" name="mdp"><br><br>
			  	<input type="submit" name="Valider">
			</form>
		</section>

	</div>

</body>
</html>