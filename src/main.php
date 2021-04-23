<?php
include_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project manager</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<!--    <link href="css/style.css" rel="stylesheet">-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1b94fb06eb.js"
    crossorigin="anonymous"></script>
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="hamburger"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="left-menu">
        <ul>
            <li><a href="#"><i class="fas fa-th-large"></i><p class="left-menu-titles">DASHBOARD</p></a></li>
            <li><a href="#"><i class="fas fa-folder"></i><p class="left-menu-titles">PROJECTS</p></a></li>
            <li><a href="#"><i class="fas fa-history"></i><p class="left-menu-titles">HISTORY</p></a></li>
            <li><a href="#"><i class="fas fa-plus-circle"></i><p class="left-menu-titles">NEW PROJECT</p></a></li>
</ul>
    </div>
    <section>
<header>
    <nav class="navbar">
        <a class="project-page-title mr-auto">PROJECTS</a>
        <div class="whole-search"><input type="text" id="search" name="fname" placeholder="Search"><i class="fas fa-search" id="search-icon"></i></div>
        <div class="form-inline">
            <?php
            echo '<p class="login-name">' . $_SESSION["name"] . '</p>';
            ?>
            <form method="POST">
                <button type="submit" name="logout"><i class="fas fa-sign-out-alt"></i></button>
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

        // $queryM = "SELECT Projekto_id, Pavadinimas, Aprasymas, Busena, Sukurimo_data, Visos_uzduotys, Neatliktos_uzduotys FROM projektai";
        $queryM = "SELECT
            projektai.Projekto_id,
            projektai.Pavadinimas,
            projektai.Aprasymas,
            projektai.Vartotojai,
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
            <td>".$row['Pavadinimas']."</td>
            <td>".$row['Aprasymas']."</td>
            <td>".$row['Busena']."</td>
            <td class='progresss'>
            <p class='progress-numbers'>".$row['Total_tasks']."/".$row['Todo_tasks']."</p>
            <div class='hover-info'>All tasks: ".$row['Total_tasks'].", Finished tasks".($row['Total_tasks'] - $row['Todo_tasks']).", To do tasks: ".$row['Todo_tasks'].".</div><div class='round'>
            <div class='progress-colors'></div></div></td>
          <td class='td-spacing'>
          <button><a href='update-process.php?Pavadinimas=".$row['Pavadinimas']."'>"."<i class='far fa-edit'></i></a></button>
          <button><i class='far fa-trash-alt'></i></button>
          <button><i class='fas fa-archive'></i></button>
          <button><i class='fas fa-arrow-down'></i></button></td>
          <td><button id='create-button'><i class='fas fa-plus-circle' id='plus-button'></i></button></td></tr>";
            break;
            }
            echo "<tr>
            <td class='grey-border'>".$row['Pavadinimas']."</td>
            <td class='grey-border'>".$row['Aprasymas']."</td>
            <td class='grey-border'>".$row['Busena']."</td>
            <td class='grey-border progresss'>
            <p class='progress-numbers'>".$row['Total_tasks']."/".$row['Todo_tasks']."</p>
            <div class='round'>
            <div class='progress-colors'></div></div></td>
          <td class='grey-border'>
          <button><a href='update-process.php?Pavadinimas=".$row['Pavadinimas']."'>"."<i class='far fa-edit'></i></a></button>
          <button><i class='far fa-trash-alt'></i></button>
          <button><i class='fas fa-archive'></i></button>
          <button><i class='fas fa-arrow-down'></i></button></td></tr>";
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
    ?>
</main>
    </section>
    </body>
</html>
