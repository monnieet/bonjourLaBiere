<?php 

// Connect to the database (recover a $db variable)
require_once('./admin/connectBdd.php');

// Get moment
$presentDate = date('Y-m-d');
$presentTime = date('H:i');

// Queries for beers that are online and those that are approved and wait to be online
$notOnlineAndApprovedBeers = $db->query("SELECT * FROM `images_bieres` WHERE Date='0000-00-0' AND `Approved`=1 ORDER BY ID;");
$oldestNotOnlineAndApprovedBeer = $notOnlineAndApprovedBeers->fetch();
$onlineBeers = $db->query("SELECT * FROM `images_bieres` WHERE Date!='0000-00-0' ORDER BY Date DESC;");

// Array to browse beers, index to select the beer in the array
$onlineBeersArray = array();
while ($biere = $onlineBeers->fetch()) {
	array_push($onlineBeersArray, $biere);
}
$imageBiereIdx = 0;
$beerToAdd = False;

// Check there is a beer to add and if it is at least 10am
if ($oldestNotOnlineAndApprovedBeer && strtotime($presentTime)>strtotime('9:59')) {
	// Check if the beer of the day have already been picked
	if (count($onlineBeersArray)) {
		if ($onlineBeersArray[0]['Date']!=$presentDate) {
			$beerOfTheDay = $oldestNotOnlineAndApprovedBeer;
			$beerToAdd = True;
		}
	} else {
		$beerOfTheDay = $oldestNotOnlineAndApprovedBeer;
		$beerToAdd = True;
	}

	// Modify 'date' and 'online' values of the beer of the day that will be added
	if ($beerToAdd) {
		$query = $db->prepare("UPDATE `images_bieres` SET `Online`=:Online, `Date`=:presentDate WHERE `ID`=:id;");
		$query->bindValue(':Online', 1, PDO::PARAM_BOOL);
		$query->bindValue(':presentDate', $presentDate, PDO::PARAM_STR);
		$query->bindValue(':id', $beerOfTheDay['ID'], PDO::PARAM_INT);
		$query->execute();
		$onlineBeers = $db->query("SELECT * FROM `images_bieres` WHERE Date!='0000-00-0' ORDER BY Date DESC;");
		$onlineBeersArray = array();
		while ($biere = $onlineBeers->fetch()) {
			array_push($onlineBeersArray, $biere);
	}
	}
}

// Allow user to browse the array of online beers
if (isset($_GET['move']) && isset($_GET['idx'])) {
	$move = $_GET['move'];
	$idx = $_GET['idx'];
	if (($idx==0 && $move==-1) || ($idx==count($onlineBeersArray)-1 && $move==1)) {
		$imageBiereIdx = $idx;
	} else {
		$imageBiereIdx = $idx + $move;
	}
}

// disconnect from the database
require_once('./admin/deconnectBdd.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bonjour la Biere</title>
	<link rel="stylesheet" type="text/css" href="./css/home.css">
</head>

<body>

	<div id="bloc_page">

		<header>

			<div id="menu">
				<div id="nom"><h1>Bonjour la bière</h1></div>

				<nav>
					<ul>
						<li><a href="#">Accueil</a></li>
						<li><a href="aPropos.html">À propos</a></li>
						<li><a href="suggestion.php">Suggestion ?</a></li>
					</ul>
				</nav>
			</div>
			
		</header>


		<section id="displayBeer">
			<?php 
			// Display elements if at least there is one online beer
			if (count($onlineBeersArray)>0) {
				$biere = $onlineBeersArray[$imageBiereIdx];
			?>

				<img src="<?=$biere['Img']?>" alt="beer image" class="beerImage"/>
				<p>Image du jour: <?= $biere['Date'] ?></p>
				<p>Description: <?= $biere['Description'] ?></p>
				<?php 
				// Display arrows to browse online beers according the array (end of the array, one element...)
				if (count($onlineBeersArray)==1) {
				?>
					<p><a href="#" title="No previous picture"><img src="images/endPrecedent.png" alt="Arrow end previous Pict" height="75px" width="75px"></a><a href="#" title="No next picture"><img src="images/endSuivant.png" alt="Arrow end next Pict" height="75px" width="75px"></a></p>
				<?php
				} elseif ($imageBiereIdx==0) {
				?>
					<p><a href="home.php?move=1&idx=<?= $imageBiereIdx ?>" target="" title="Previous picture"><img src="images/precedent.png" alt="Arrow previous Pict" height="75px" width="75px"></a><a href="#>" title="No next picture"><img src="images/endSuivant.png" alt="Arrow end next Pict" height="75px" width="75px"></a></p>
				<?php
				} elseif ($imageBiereIdx==count($onlineBeersArray)-1) {
				?>
					<p><a href="#" title="No previous picture"><img src="images/endPrecedent.png" alt="Arrow end previous Pict" height="75px" width="75px"></a></a><a href="home.php?move=-1&idx=<?= $imageBiereIdx ?>" title="Next picture"><img src="images/suivant.png" alt="Arrow next Pict" height="75px" width="75px"></a></p>
				<?php
				} else {
				?>	
					<p><a href="home.php?move=1&idx=<?= $imageBiereIdx ?>" target="" title="Previous picture"><img src="images/precedent.png" alt="Arrow previous Pict" height="75px" width="75px"></a><a href="home.php?move=-1&idx=<?= $imageBiereIdx ?>" title="Next picture"><img src="images/suivant.png" alt="Arrow next Pict" height="75px" width="75px"></a></p>
			<?php
			} 
			} else {
			?> <p>BASE DE DONNEES VIDE...LA REMPLIR COTE ADMIN OU PAR SUGGESTIONS !</p>
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