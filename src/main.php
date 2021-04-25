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
include_once('header.php');
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
<!--    <link href="css/style.css?rnd=132" rel="stylesheet">-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/createForm.css?rnd=235" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1b94fb06eb.js"
    crossorigin="anonymous"></script>
</head>
<body>
    <input type="checkbox" id="check" class="input">
    <label for="check" class="label">
        <i class="fas fa-bars" id="hamburger"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="left-menu">
        <ul>
            <li><a href="#"><i class="fas fa-th-large"></i><p class="left-menu-titles">DASHBOARD</p></a></li>
            <li><a href="#"><i class="fas fa-folder"></i><p class="left-menu-titles">PROJECTS</p></a></li>
            <li><a href="#"><i class="fas fa-history"></i><p class="left-menu-titles">HISTORY</p></a></li>
            <li><a href="#" class="create-project__JS"><i class="fas fa-plus-circle"></i><p class="left-menu-titles ">NEW PROJECT</p></a></li>
        </ul>
    </div>
    <section>
<header>
    <nav class="navbar">
        <a class="project-page-title mr-auto">PROJECTS</a>
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
</header>
<main>
    <?php
        try {
        $connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
        $connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // $queryM = "SELECT Projekto_id, Pavadinimas, Aprasymas, Busena, Sukurimo_data, Visos_uzduotys, Neatliktos_uzduotys FROM projektai";
        $queryM = "SELECT
            projektai.Projekto_id,
            projektai.Pavadinimas,
            projektai.Aprasymas,
            projektai.Busena,
            projektai.Sukurimo_data,
            SUM(case when uzduotys.Busena ='Done' then 1 else 0 end) as Finished_tasks,
            SUM(case when uzduotys.Busena ='To Do' then 1 else 0 end) as Todo_tasks,
            COUNT(uzduotys.Busena) as Total_tasks
        FROM projektai
        LEFT JOIN projektu_uzduotys ON projektu_uzduotys.Projekto_id = projektai.Projekto_id
        LEFT JOIN uzduotys ON uzduotys.Uzduoties_id = projektu_uzduotys.Uzduoties_id
        GROUP BY 1";
        $result = $connectM->prepare($queryM);
        $result->execute();
        $number = $result->rowCount(); //paskutines eilus stilizavimui reikalinga
        $i = 1;
            // count naudosime, jei noresime nustatyti eiluciu skaiciu
        // $count = 1;


                //  isspausdinamas projektu sarasas
        echo "<table>";
        echo "<thead>";
        echo "<tr><th class='project-name-spacing'>PROJECT NAME</th><th>DESCRIPTION</th><th>STATUS</th><th class='completion-spacing'>COMPLETION</th><th></th></tr>";
        echo "</thead>";
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            if ($i == $number)
            {
            echo "<tr>
            <td class='d-none'>".$row['Projekto_id']."</td>
            <td>".$row['Pavadinimas']."</td>
            <td>".$row['Aprasymas']."</td>
            <td>".$row['Busena']."</td>
            <td class='progresss'>
            <p class='progress-numbers'>".$row['Total_tasks']."/".$row['Todo_tasks']."</p>
            <div class='hover-info'>All tasks: ".$row['Total_tasks'].", Finished tasks".($row['Total_tasks'] - $row['Todo_tasks']).", To do tasks: ".$row['Todo_tasks'].".</div>
            <div class='round'><div class='progress-colors'></div></div></td>
          <td class='td-spacing'>
          <button><a href='update-process.php?Projekto_id=".$row['Projekto_id']."'>"."<i class='far fa-edit'></i></a></button>
          <button><a href='delete.php?Projekto_id=".$row['Projekto_id']."'>"."<i class='far fa-trash-alt'></i></a></button>
          <button class=\"button\"><i class='fas fa-archive'></i></button>
          <button class=\"button\"><i class='fas fa-arrow-down'></i></button></td>
          <td><button class=\"button\" id='create-button'>
          <i class='fas fa-plus-circle' id='plus-button'></i></button></td></tr>";
            break;
            }
                echo "<tr>
                <td class='d-none'>".$row['Projekto_id']."</td>
                <td class='grey-border'>".$row['Pavadinimas']."</td>
                <td class='grey-border'>".$row['Aprasymas']."</td>
                <td class='grey-border'>".$row['Busena']."</td>
                <td class='grey-border progresss'>
                <p class='progress-numbers'>".$row['Total_tasks']."/".$row['Todo_tasks']."</p>
                <div class='round'><div class='progress-colors'></div></div></td>
                <td class='grey-border'>
                <button><a href='update-process.php?Projekto_id=".$row['Projekto_id']."'>"."<i class='far fa-edit'></i></a></button>
          <button><a href='delete.php?Projekto_id=".$row['Projekto_id']."'>"."<i class='far fa-trash-alt'></i></a></button>
                <button class=\"button\">
                <i class='fas fa-archive'></i></button>
                <button class=\"button\"><i class='fas fa-arrow-down'></i></button></td></tr>";
            // $count++;
            // if ($count>2) {
            //     break;  cia galesime nustatyti salygas, kas bus kai pvz isspausdins 10 eiluciu
            // }
            $i++;
        }
        echo "</table>";
        echo "<br>";
    } catch (PDOException $error) {  //Jei nepavyksta prisijungti ismeta klaidos pranesima


        echo $error->getMessage();
        }
        //Pridedamas html blur'as, jei nesekminga uzklausa ('toks pavadinimas jau yra' ir t.t.)
        echo isset($_POST['title']) ? '<div class="blur__JS"></div>' : '';
    ?>
    <div class="pop-up <?php echo isset($_POST['title']) ? 'pop-up__JS' : '';?>">
        <h2 class="pop-up__h2">Create a new project</h2>
        <form method="POST" class="pop-up__form">
            <input class="pop-up__input" type="text" name="title" placeholder="Project title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Project title'" required>
            <label for="description" class="pop-up__placeholder">Description</label><textarea class="pop-up__textarea" name="description" rows="6"></textarea>
            <div class="pop-up--flex">
                <input type="submit" name="create" value="Create" class="pop-up__create-btn pop-up__input" id="project-btn">
                <div role="button" class="pop-up__cancel-btn">Cancel</div>
            </div>
            <?php
            if(isset($_POST['title']))  {
                $test1 = new Project();
                $test1->createProject($_POST['title'], $_POST['description'], $_SESSION['userId']);
            }
            if(isset($_SESSION['message'])){
                echo "<p class='pop-up__error'>".$_SESSION['message']."</p>";
                unset($_SESSION['message']);
            }
            ?>
        </form>
    </div>
    </main>
    <script src="./js/createProject.js?rnd=132"></script>
    </section>
    </body>
</html>
