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

</html>