<?php
session_start();
if (isset($_SESSION["username"])) {
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location:index.php");
    }
} else {
    header("location:index.php");
}
//auto-loader pakrauna reikiamas klases
require_once 'includes/auto-loader.inc.php';
include_once('db_config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project manager</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="css/style.css?rnd=132" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/createForm.css?rnd=235" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1b94fb06eb.js"
    crossorigin="anonymous"></script>
    <script>
        function displayError (){
            document.querySelector('.pop-up__update').classList.add('pop-up__JS');
            const blur = document.createElement('div');
            blur.classList.add('blur__JS');
            document.body.appendChild(blur);
        }
    </script>
</head>
<body>
    <!-- Kairinis menu -->
    <input type="checkbox" id="check" class="input">
    <label for="check" class="label">
        <i class="fas fa-bars" id="hamburger"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="left-menu"> 
    <div class="whole-search"><input type="text" id="search-left-menu" name="fname" placeholder="search" class="input"><i class="fas fa-search left-menu-search-icon" id="search-icon"></i></div>
        <ul>
            <li><a href="#"><i class="fas fa-th-large left-menu-icon"></i><p class="left-menu-titles">DASHBOARD</p></a></li>
            <li><a href="main.php"><i class="fas fa-folder left-menu-icon"></i><p class="left-menu-titles">PROJECTS</p></a></li>
            <li><a href="#"><i class="fas fa-history left-menu-icon"></i><p class="left-menu-titles">HISTORY</p></a></li>
            <li><a href="#" class="create-project__JS"><i class="fas fa-plus-circle left-menu-icon"></i><p class="left-menu-titles ">NEW PROJECT</p></a></li>
        </ul>
    </div>
    <!-- Kairinio menu pabaiga -->
    <section>
<header>
    <!-- Viršutinė menu juosta su search ir exit laukeliais -->
    <nav class="navbar">
        <?php  if(isset($_SESSION['title'])){
            
            echo "<a class=\"project-page-title mr-auto\" style=\"font-size: 2.5rem; font-weight: 500;\"> <span style=\"text-transform:uppercase;\">".$_SESSION['title']."</span> / tasks</a>";
        }?>
        <div class="whole-search"><input type="text" id="search" name="fname" placeholder="Search" class="input"><i class="fas fa-search" id="search-icon"></i></div>
        <div class="form-inline">
            <?php
            echo '<p class="login-name">' . $_SESSION["username"] . '</p>';
            ?>
            <form method="POST">
                <button class="button" type="submit" name="logout"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </nav>
    <!-- Viršutinės menu juostos pabaiga -->
</header>
<main>
    <?php
    // Jungiamės prie duombazės
        echo "<table>";
        echo "<thead>";
        echo "<tr>
        <th  class='project-name-spacing' style=\"text-transform: uppercase;\">Id</th>
        <th style=\"text-transform: uppercase;\">Task</th>
        <th style=\"text-transform: uppercase;\">Description</th>
        <th style=\"text-transform: uppercase;\">Priority</th>
        <th style=\"text-transform: uppercase;\">Status</th>
        <th style=\"text-transform: uppercase;\">Created</th>
        <th class='round-border' style=\"text-transform: uppercase;\">Modified</th></tr>";
        echo "</thead>";
        echo "</table>";
        echo "<br>";
    ?>
</main>
<script src="./js/createProject.js?rnd=132"></script>
</section>
</body>
<!-- <button><a href='update-process.php?Projekto_id=".$row['Projekto_id']."'>"."<i class='far fa-edit'></i></a></button> -->
</html>
