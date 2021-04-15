<?php
session_start();  
if(isset($_SESSION["name"])){
	if(isset($_POST['logout'])){
		session_destroy();  
		header("location:index.php");  
	}
	echo  "
	<p>".$_SESSION["name"]."</p>
	<form method=\"POST\"><input type=\"submit\" name=\"logout\" value=\"logout\"/></form>
	";
}else{
	header("location:index.php");  
}

