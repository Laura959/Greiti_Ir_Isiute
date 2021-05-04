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
    <link href="css/style.css?rnd=123" rel="stylesheet">
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
        <i class="fas fa-bars " id="hamburger"></i>
        <i class="fas fa-times " id="cancel"></i>
    </label>
    <div class="left-menu"> 
    <div class="whole-search"><input type="text" id="search-left-menu" name="fname" placeholder="search" class="input"><i class="fas fa-search left-menu-search-icon " id="search-icon"></i></div>
        <ul>
            <li><a href="#"><i class="fas fa-th-large left-menu-icon "></i><p class="left-menu-titles">DASHBOARD</p></a></li>
            <li><a href="main.php"><i class="fas fa-folder left-menu-icon "></i><p class="left-menu-titles">PROJECTS</p></a></li>
            <li><a href="#"><i class="fas fa-history left-menu-icon "></i><p class="left-menu-titles">HISTORY</p></a></li>
            <li><a href="#" class="create-project__JS"><i class="fas fa-plus-circle left-menu-icon "></i><p class="left-menu-titles ">NEW PROJECT</p></a></li>
        </ul>
    </div>
    <!-- Kairinio menu pabaiga -->
    <section>
<header>
    <!-- Viršutinė menu juosta su search ir exit laukeliais -->
    <nav class="navbar">
        <?php  if(isset($_GET['title'])){
            echo "<a class=\"project-page-title  tasks__title mr-auto\"> <span class=\"tasks__title--uppercase\">".$_GET['title']."</span> / Tasks</a>";
        }else{
            echo "<a class=\"project-page-title tasks__title  mr-auto\"> - / Tasks</a>";
        }?>
        <div class="whole-search"><input type="text" id="search" name="fname" placeholder="Search" class="input"><i class="fas fa-search" id="search-icon"></i></div>
        <div class="form-inline"  style="margin-left: 2.5%;">
            <?php
            echo '<p class="login-name">' . $_SESSION["username"] . '</p>';
            ?>
            <form method="POST">
                <button class="button" type="submit" name="logout"><i class="fas fa-sign-out-alt "></i></button>
            </form>
        </div>
    </nav>
    <!-- Viršutinės menu juostos pabaiga -->
</header>
<main>
<?php
    echo "
    <table class=\"table--fixed\">
        <thead class=\"tasks__thead\" style=\"position: relative;\">
            <tr>
                <th class='project-name-spacing tasks__th'>ID</th>
                <th class='tasks__th--width tasks__th'>Task</th>
                <th class='tasks__th--width tasks__th'>Description</th>
                <th class='tasks__th'>Priority</th>
                <th class='tasks__th'>Status</th>
                <th class='tasks__th'>Created</th>
                <th class='tasks__th'>Modified</th>
                <th class='round-border tasks__th'></th>
            </tr>";
    if(isset($_GET['Projekto_id'])){
        try {
            $connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
            $connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL užklausa, iš kurios gausime projektų lentelei reikalingus rezultatus
            $queryM = "SELECT * FROM uzduotys WHERE Projekto_id =".$_GET['Projekto_id']."";
            $result = $connectM->prepare($queryM);
            $result->execute();
            $number = $result->rowCount(); //paskutines eilus stilizavimui reikalinga
            $i = 1;
            if($number === 0){
                $_SESSION['empty'] = true;
            }
            echo "</thead>";
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                if ($i == $number)
                {
                    // spausdinama eilutė su "Sukurti projektą mygtuku
                    echo "
                    <tr>
                        <td class='tasks__td'>".$row['Uzduoties_id']."</td>
                        <td class='tasks__td'>".$row['Pavadinimas']."</td>
                        <td class='tasks__td'>".$row['Aprasymas']."</td>
                        <td class=\"tasks__td tasks__priority-".$row['Prioritetas']."\"\">".$row['Prioritetas']."</td>
                        <td class='tasks__td'>".$row['Busena']."</td>
                        <td class='tasks__td'>".$row['Sukurimo_data']."</td>
                        <td class='tasks__td'>".$row['Naujinimo_data']."</td>
                        <td class='tasks__td'>
                            <button class=\"update-project__JS\">
                                <i class='far fa-edit '></i>
                            </button>
                            <button class=\"delete-project__JS\" id=\"".$row['Uzduoties_id']."\">
                                <i class='far fa-trash-alt '></i>
                            </button>
                            <button class=\"button\">
                                <i class='fas fa-arrow-down '></i>
                            </button>
                            <button class=\"button\" id='create-button' style='padding: 0;'>
                                <i class='fas fa-plus-circle create-project__JS ' id='plus-button' style=\"bottom: -2.75rem; right: -2rem;\"></i>
                            </button>
                        </td>
                    </tr>";
                break;
                }
                    // spausdinamos kitos lentelės eilutės
                    echo "
                    <tr class='tasks__tr--border-bottom'>
                        <td class='tasks__td'>".$row['Uzduoties_id']."</td>
                        <td class='tasks__td'>".$row['Pavadinimas']."</td>
                        <td class='tasks__td'>".$row['Aprasymas']."</td>
                        <td class=\"tasks__td tasks__priority-".$row['Prioritetas']."\">".$row['Prioritetas']."</td>
                        <td class='tasks__td'>".$row['Busena']."</td>
                        <td class='tasks__td'>".$row['Sukurimo_data']."</td>
                        <td class='tasks__td'>".$row['Naujinimo_data']."</td>
                        <td class='tasks__td'>
                            <button class=\"update-project__JS\">
                                <i class='far fa-edit '></i>
                            </button>
                            <button class=\"delete-project__JS\" id=\"".$row['Uzduoties_id']."\">
                                <i class='far fa-trash-alt '></i>
                            </button>
                            <button class=\"button\">
                                <i class='fas fa-arrow-down '></i>
                            </button>
                        </td>
                    </tr>";
                $i++;
            }
        } catch (PDOException $error) {  //Jei nepavyksta prisijungti ismeta klaidos pranesima
            echo $error->getMessage();
        }
    }
    echo "
        </table>
        <br>";
    if(isset($_SESSION['empty']) && isset($_GET['title'])){
        echo "
        <button id='create-button' class=\"tasks__add-btn\">
            <i class='fas fa-plus-circle create-project__JS tasks__add-btn-i' id='plus-button'></i>
        </button>";
        unset($_SESSION['empty']);
    }
    ?>
</main>
<script src="./js/createProject.js?rnd=132"></script>
</section>
</body>
</html>
