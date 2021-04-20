<?php
session_start();
if (isset($_SESSION["name"])) {
	if (isset($_POST['logout'])) {
		session_destroy();
		header("location:index.php");
	}
} else {
	header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Project manager</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
</head>
<header>
	<nav class="navbar navbar-dark bg-dark">
		<a class="navbar-brand mr-auto">Project manager</a>
		<div class="form-inline">
			<?php
			echo '<p class="login-name">' . $_SESSION["name"] . '</p>';
			?>
			<form class="form-unstyled" method="POST">
				<button type="submit" name="logout" class="btn btn-outline-success my-2 my-sm-0">Log out</button>
			</form>
		</div>
	</nav>
</header>
<main>
	<?php
		include_once('db_config.php');
		try {
		$connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
		$connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $queryM = "SELECT Projekto_id, Pavadinimas, Aprasymas, Busena, Sukurimo_data, Visos_uzduotys, Neatliktos_uzduotys FROM projektai";
		$result = $connectM->prepare($queryM);  
		$result->execute();
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		//  isspausdinamas projektu sarasas
		echo "<table>";
		echo "<h3>PROJEKTAI</h3>";
		echo "<tr><th>ID</th><th>TITLE</th><th>DESCRIPTION</th><th>STATE</th><th>CREATION DATE</th><th>ALL TASKS</th><th>UNFINISHED TASKS</th></tr>";
		foreach($data as $row){   
			echo "<tr><td>".$row['Projekto_id']."</td><td>".$row['Pavadinimas']."</td><td>".$row['Aprasymas']."</td><td>".$row['Busena']."</td><td>".$row['Sukurimo_data']."</td><td>".$row['Visos_uzduotys']."</td><td>".$row['Neatliktos_uzduotys']."</td></tr>";
		}       
		echo "</table>";
		echo "<br>";
	} catch (PDOException $error) {  //Jei nepavyksta prisijungti ismeta klaidos pranesima    
		echo $error->getMessage();
		}
	?>
</main>
</html>