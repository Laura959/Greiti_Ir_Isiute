<?php
session_start();

if (isset($_GET['title']) && (!isset($_COOKIE['Projektas']))) {
    setcookie("Projektas", $_GET['title'], time() + (3600));
}

if (isset($_GET['Projekto_id']) && (!isset($_COOKIE['Projekto_id']))) {
    setcookie("Projekto_id", $_GET['Projekto_id'], time() + (3600));
}

if (isset($_SESSION["username"])) {
    if (isset($_POST['logout'])) {
        session_destroy();
        setcookie("Projektas", "", time() - 3600);
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
        <meta content='width=device-width; initial-scale=1.0;' name='viewport' />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link href="css/style.css?rnd=326" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="css/createForm.css?rnd=711" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/1b94fb06eb.js"
        crossorigin="anonymous"></script>

    </head>
    <body>
        <!-- Kairinis menu -->
        <div class="left-menu"> 
            <div class="left-menu__controls">
                <button class="left-menu__show-btn left-menu__btn">
                    <i class="fas fa-bars" id="hamburger"></i>
                </button>
                <button class="left-menu__hide-btn left-menu__btn">
                    <i class="fas fa-times" id="cancel"></i>
                </button>
            </div>
            <div class="left-menu__list">
                <ul class="left-menu__items">

                    <li class="left-menu__item">
                        <a href="main.php" class="left-menu__icon">
                            <i class="fas fa-folder left-menu-icon " data-text="Projects"></i>
                        </a>
                        <a href="main.php" class="left-menu__title">Projects</a>
                    </li>
                    <li class="left-menu__item left-menu__item-hover">
                        <a href="#" download="History.csv" class="left-menu__icon export">
                            <i class="fas fa-file-download left-menu-icon" data-text="Export history"></i>
                        </a>
                        <p class="left-menu__title">
                            <span class="export__span">Export History</span>
                        </p>
                    </li>
                    <?php
                    $usersinfo = "";
                    if (isset($_GET['Projekto_id'])) {
                        try {
                            $connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
                            $connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "
                            SELECT vartotojai.Vardas, vartotojai.Pavarde FROM vartotojai
                            LEFT JOIN komandos ON komandos.Vartotojas = vartotojai.Vartotojo_id
                            LEFT JOIN projektai ON projektai.Projekto_id = komandos.Projekto_id
                            WHERE projektai.Projekto_id =" . $_GET['Projekto_id'] . "
                        ";
                        } catch (PDOException $error) {  //Jei nepavyksta prisijungti ismeta klaidos pranesima
                            echo $error->getMessage();
                        }
                        $result = $connectM->prepare($sql);
                        $result->execute();
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $usersinfo .= $row['Vardas'] . " " . $row['Pavarde'] . ",";
                        }
                    }
                    ?>
                    <li class="left-menu__item manage-members__JS" data-users="<?php echo $usersinfo; ?>">
                        <a href="#" class="left-menu__icon">
                            <i class="fas fa-users left-menu-icon members-btn" data-text="Manage members"></i>
                        </a>
                        <p class="left-menu__title left-menu__title--margin">Manage members</p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Kairinio menu pabaiga -->
        <section>
            <header>
                <!-- Viršutinė menu juosta su search ir exit laukeliais -->
                <nav class="navbar tasks__navbar">

                    <?php
                    if (isset($_COOKIE["Projektas"])) {
                        echo "<h2 class=\"project-page-title  tasks__title mr-auto\"> <span class=\"tasks__title--uppercase\">" . $_COOKIE["Projektas"] . "</span> / Tasks</h2>";
                    } else if (isset($_GET['title'])) {
                        echo "<h2 class=\"project-page-title  tasks__title mr-auto\"> <span class=\"tasks__title--uppercase\">" . $_GET['title'] . "</span> / Tasks</h2>";
                    } else {
                        echo "<h2 class=\"project-page-title tasks__title  mr-auto\"> History</h2>";
                    }
                    ?>
                    <div class="whole-search tasks__search"> <!-- SEARCH FUNKCIALUMAS -->        
                        <form id="search-form">
                            <?php
                            if (isset($_GET["search"])) {
                                $SEARCH_QUERY = trim($_GET["search"]);
                                $SEARCH_QUERY_LENGTH = strlen($SEARCH_QUERY);
                                // if($SEARCH_QUERY_LENGTH > 0 && $SEARCH_QUERY_LENGTH < 3 && !is_numeric($SEARCH_QUERY)) {
                                //     $SEARCH_ERROR = "Enter at least 3 symbols";
                                // }
                            } else {
                                $SEARCH_QUERY = "";
                            }
                            echo "<input type=\"text\" id=\"search\" name=\"search\" value=\"" . $SEARCH_QUERY . "\" placeholder=\"Search tasks\" class=\"search-form__input\" pattern=\"\w{3,}||[0-9]\" title=\"Enter at least 3 symbols\">
            <i class=\"fas fa-search\" id=\"search-icon\"></i>";
                            // if(isset($SEARCH_ERROR)) {
                            //     echo "<br /><span style=\"color: red; font-style:italic;\"> " . $SEARCH_ERROR . "</span";
                            // }
                            ?>
                        </form>
                        <div class="form-inline">
                            <?php
                            echo '<p class="login-name">' . $_SESSION["username"] . '</p>';
                            ?>
                            <form method="POST">
                                <button class="button" type="submit" name="logout"><i class="fas fa-sign-out-alt "></i></button>
                            </form>
                        </div>
                    </div>

            </header>
            <main>
                <?php
                try {
                    $connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
                    $connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $queryM = "SELECT History_id, Ivykio_tipas,Ivykio_vardas, Pakeitimo_data, Vartotojo_id, Vardas FROM history ORDER BY Pakeitimo_data DESC";
                    $linkCSV_history = "data:text/csv;charset=utf-8, ID, Event Type, Project / Task name, Modification date, User\n";


                    $result = $connectM->prepare($queryM);
                    $result->execute();
                    $number = $result->rowCount(); //paskutines eilus stilizavimui reikalinga
                    $i = 1;
                    if ($number === 0) {
                        $_SESSION['empty'] = true;
                    }
                    if ($number == 0 && isset($SEARCH_QUERY)) {
                        echo "<div class=\"error-search-group\"> <img src=\"projects.png\" class=\"error-search-img\"> <span class=\"error-search-message\"> Task with this name does not exist</span></div>";
                    } else {
                        echo "
            <table class=\"table--fixed tasks-table\">
                <thead class=\"tasks__thead\" style=\"position: relative;\">
                    <tr>
                        <th class='project-name-spacing tasks__th'>ID</th>
                        <th class='tasks__th--width tasks__th tasks__th--radius tasks__th--text-align'>Event type </th>
                        <th class='tasks__th--width tasks__th tasks__th--radius tasks__th--text-align'>Project / Task name</th>
                        <th class='tasks__th--width tasks__th'>Modification date </th>
                        <th class='tasks__th'>User</th>
                        </tr>";
                    }

                    echo "</thead>";
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $linkCSV_history .= "&quot;" . $row['History_id'] . "&quot;,&quot;" . $row['Ivykio_tipas'] . "&quot;," . $row['Ivykio_vardas'] . "," . $row['Pakeitimo_data'] . "," . $row['Vardas'] . "\n";
                        if ($i == $number) {
                            // spausdinama eilutė su "Sukurti projektą mygtuku
                            echo "

                    <tr>
                        <td class='tasks__td'>" . $row['History_id'] . "</td>
                        <td class='tasks__td'>" . $row['Ivykio_tipas'] . "</td>
                        <td class='tasks__td'>" . $row['Ivykio_vardas'] . "</td>
                        <td class='tasks__td'>" . $row['Pakeitimo_data'] . "</td>
                        <td class='tasks__td'>" . $row['Vardas'] . "</td>
                        
                     <button class=\"button\" id='create-button' style='display:none' aria-label=\"create a project\">
          <i class='fas fa-plus-circle create-project__JS add-project-btn' id='plus-button' data-link=\"" . $linkCSV_history . "\"></i></button></td>
                     
                    </tr>";
                            break;
                        }
                        // spausdinamos kitos lentelės eilutės
                        echo "
                    <tr class='tasks__tr--border-bottom'>
                       <td class='tasks__td'>" . $row['History_id'] . "</td>
                        <td class='tasks__td'>" . $row['Ivykio_tipas'] . "</td>
                        <td class='tasks__td'>" . $row['Ivykio_vardas'] . "</td>
                        <td class='tasks__td'>" . $row['Pakeitimo_data'] . "</td>
                        <td class='tasks__td'>" . $row['Vardas'] . "</td>

                       
                      
                    </tr>";
                        $i++;
                    }
                } catch (PDOException $error) {  //Jei nepavyksta prisijungti ismeta klaidos pranesima
                    echo $error->getMessage();
                }

                echo "
        </table>
        <br>";
                ?>



            </main>
            <script type="module" src="./js/createProject.js?rnd=217"></script>
        </section>
    </body>


</html>