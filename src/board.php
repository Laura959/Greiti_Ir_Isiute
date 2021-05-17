<?php
session_start();
if (isset($_COOKIE["Projektas"])) {
    setcookie("Projektas", "", time() - 3600);
}
if (isset($_COOKIE["Projekto_id"])) {
    setcookie("Projekto_id", "", time() - 3600);
}


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
    <link href="css/style.css?rnd=235" rel="stylesheet">
    <link href="css/board.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/createForm.css?rnd=132" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1b94fb06eb.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Kairinis menu -->
    <input type="checkbox" id="check" class="input">
    <label for="check" class="label">
        <i class="fas fa-bars" id="hamburger"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="left-menu">
        <ul>
            <li><a href="#"><i class="fas fa-th-large left-menu-icon"></i>
                    <p class="left-menu-titles">DASHBOARD</p>
                </a></li>
            <li><a href="#"><i class="fas fa-folder left-menu-icon"></i>
                    <p class="left-menu-titles">PROJECTS</p>
                </a></li>
            <li><a href="#" class="export" download="Projects.csv"><i class="fas export-icon fa-arrow-down left-menu-icon"></i>
                    <p class="left-menu-titles"><span class="export__span">EXPORT</span></p>
                </a></li>
            <li><a href="#"><i class="fas fa-history left-menu-icon"></i>
                    <p class="left-menu-titles">HISTORY</p>
                </a></li>
            <li><a href="#" class="create-project__JS"><i class="fas fa-plus-circle left-menu-icon"></i>
                    <p class="left-menu-titles ">NEW PROJECT</p>
                </a></li>
        </ul>
    </div>
    <!-- Kairinio menu pabaiga -->
    <section>
        <header>
            <!-- Viršutinė menu juosta su search ir exit laukeliais -->
            <nav class="navbar">
                <a class="project-page-title mr-auto" download="Projects.csv">PROJECTS</a>
                <div class="whole-search">

                    <!-- SEARCH FUNKCIALUMAS -->
                    <form id="search-form">
                        <?php
                        if (isset($_GET["search"])) {
                            $SEARCH_QUERY = trim($_GET["search"]);
                            $SEARCH_QUERY_LENGTH = strlen($SEARCH_QUERY);
                            if ($SEARCH_QUERY_LENGTH > 0 && $SEARCH_QUERY_LENGTH < 3) {
                                // $SEARCH_ERROR = "error";
                            }
                        } else {
                            $SEARCH_QUERY = "";
                        }
                        echo "<input type=\"text\" id=\"search\" name=\"search\" value=\"" . $SEARCH_QUERY . "\" placeholder=\"search projects\" class=\"input\" pattern=\"([0-9_-]*[a-zA-Z_ ,][0-9_-]*){3,}\" title=\"Enter atleast 3 symbols\">
            <i class=\"fas fa-search\" id=\"search-icon\"></i>";

                        // if(isset($SEARCH_ERROR)) {
                        //     echo "<br /><span style=\"color: red\"> " . $SEARCH_ERROR . "</span";               
                        // }
                        ?>
                    </form>
                </div>
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

        <!-- TASK BOARDS -->
        <main>
            <div class="board-container">
                <div class="task-board">
                    <div class="board-header">to do</div>
                    <div class="board-background">
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                        <div class="board-data"><span class="dot dot--middle"></span>123456</div>
                        <div class="board-data"><span class="dot dot--high"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse eget ligula non augue finibus mattis. Phasellus eget massa in nulla vestibulum lacinia. Ut non felis finibus sapien posuere mattis in non purus. Donec non erat aliquet nibh hendrerit vehicula. Proin eget nisl tristique, semper enim a, tincidunt sem. Vivamus tempor, lorem nec dignissim commodo, neque turpis pellentesque orci, sit amet vulputate arcu metus et ligula. Suspendisse potenti. Fusce at tristique nunc.</div>
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                    </div>
                </div>

                <div class="task-board">
                    <div class="board-header">in progress</div>
                    <div class="board-background">
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                        <div class="board-data"><span class="dot dot--middle"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse eget ligula non augue finibus mattis. Phasellus eget massa in nulla vestibulum lacinia. Ut non felis finibus sapien posuere mattis in non purus. Donec non erat aliquet nibh hendrerit vehicula. Proin eget nisl tristique, semper enim a, tincidunt sem.</div>
                        <div class="board-data"><span class="dot dot--high"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                    </div>
                </div>

                <div class="task-board">
                    <div class="board-header">done</div>
                    <div class="board-background">
                        <div class="board-data"><span class="dot dot--high"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse eget ligula non augue finibus mattis. Phasellus eget massa in nulla vestibulum lacinia. Ut non felis finibus sapien posuere mattis in non purus. Donec non erat aliquet nibh hendrerit vehicula. Proin eget nisl tristique, semper enim a, tincidunt sem. Vivamus tempor, lorem nec dignissim commodo, neque turpis pellentesque orci, sit amet vulputate arcu metus et ligula. Suspendisse potenti. Fusce at tristique nunc.</div>
                        <div class="board-data"><span class="dot dot--middle"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                        <div class="board-data"><span class="dot dot--low"></span>123456</div>
                    </div>
                </div>
            </div>
        </main>