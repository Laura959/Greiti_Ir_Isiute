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

    <link href="css/style.css?rnd=231" rel="stylesheet">
    <link href="css/board.css?rnd=123" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/createForm.css?rnd=132" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1b94fb06eb.js" crossorigin="anonymous"></script>
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
                    <a href="#" href="#" class="left-menu__icon">
                        <i class="fas fa-th-large left-menu-icon"></i>
                    </a>
                    <p class="left-menu__title">Dashboard</p>
                </li>
                <li class="left-menu__item">
                    <a href="main.php" class="left-menu__icon">
                        <i class="fas fa-folder left-menu-icon"></i>
                    </a>
                    <a href="main.php" class="left-menu__title">Projects</a>
                </li>
                <li class="left-menu__item">
                    <a href="#" class="left-menu__icon">
                        <i class="fas fa-history left-menu-icon"></i>
                    </a>
                    <p class="left-menu__title">History</p>
                </li>
                <li class="left-menu__item">
                    <a href="#" class="create-project__JS left-menu__icon">
                        <i class="fas fa-plus-circle left-menu-icon"></i>
                    </a>
                    <p class="left-menu__title">New project</p>
                </li>
            </ul>
        </div>

    </div>
    <!-- Kairinio menu pabaiga -->
    <section>
        <header>
            <!-- Viršutinė menu juosta su antrašte ir log out -->

            <nav class="navbar tasks__navbar">
                <div class="board-heading">
                    <a class="project-page-title board-page-title" href="main.php">Projects/ <?php echo isset($_GET['title']) ? $_GET['title'] : '..'; ?>/ Tasks/ Task board</a>
                </div>
                <div class="form-inline form__logout">
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
        <script src="./js/createProject.js?rnd=555" defer></script>
    </section>
    </body>
</html>
