<?php

session_start();

if (isset($_GET['title'])) {
    setcookie("Projektas", $_GET['title'], time() + (3600));
}

if(isset($_GET['Projekto_id'])){
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
        
        <?php 
        
        if(isset($_COOKIE["Projektas"])){
            echo "<a class=\"project-page-title  tasks__title mr-auto\"> <span class=\"tasks__title--uppercase\">".$_COOKIE["Projektas"]."</span> / Tasks</a>";
        }else if (isset($_GET['title'])) {
            echo "<a class=\"project-page-title  tasks__title mr-auto\"> <span class=\"tasks__title--uppercase\">".$_GET['title']."</span> / Tasks</a>";
        }else{
            echo "<a class=\"project-page-title tasks__title  mr-auto\"> - / Tasks</a>";
        }?>
        <div class="whole-search"> <!-- SEARCH FUNKCIALUMAS -->        
        <form id="search-form">
        <?php              
            if(isset($_GET["search"])) {
                $SEARCH_QUERY = trim($_GET["search"]);
                $SEARCH_QUERY_LENGTH = strlen($SEARCH_QUERY);                
                // if($SEARCH_QUERY_LENGTH > 0 && $SEARCH_QUERY_LENGTH < 3 && !is_numeric($SEARCH_QUERY)) {
                //     $SEARCH_ERROR = "Enter at least 3 symbols";
                // }
            } else {
                $SEARCH_QUERY = "";
            }
            echo "<input type=\"text\" id=\"search\" name=\"search\" value=\"" . $SEARCH_QUERY . "\" placeholder=\"search tasks\" class=\"input\" pattern=\"([0-9_-]*[a-zA-Z_ ,][0-9_-]*){3,}||[0-9]||\" title=\"Enter at least 3 symbols\">
            <i class=\"fas fa-search\" id=\"search-icon\"></i>";
            // if(isset($SEARCH_ERROR)) {
            //     echo "<br /><span style=\"color: red; font-style:italic;\"> " . $SEARCH_ERROR . "</span";
            // }
        ?>
        </form>        </div>
        <div class="form-inline"  style="margin-left: 2.5%;">
            <?php
            echo '<p class="login-name">' . $_SESSION["username"] . '</p>';
            ?>
            <form method="POST">
                <button class="button" type="submit" name="logout"><i class="fas fa-sign-out-alt "></i></button>
            </form>
        </div>

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
              
    if(isset($_COOKIE['Projekto_id']) || isset($_GET['Projekto_id'])){
        try {
            $connectM = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
            $connectM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL užklausa, iš kurios gausime projektų lentelei reikalingus rezultatus
            if (isset($SEARCH_ERROR)) {
                $queryM = "SELECT * FROM uzduotys WHERE Projekto_id =".$_COOKIE['Projekto_id']." ORDER BY Eiles_nr DESC";
            } 
            else if (isset($_COOKIE['Projekto_id'])) {
            $queryM = "SELECT * FROM uzduotys WHERE Projekto_id =".$_COOKIE['Projekto_id']." AND (uzduotys.Pavadinimas LIKE '%" . $SEARCH_QUERY . "%' OR uzduotys.Uzduoties_id  LIKE '%" . $SEARCH_QUERY . "%') ORDER BY Eiles_nr DESC";
            } 
            else {
            $queryM = "SELECT * FROM uzduotys WHERE Projekto_id =".$_GET['Projekto_id']." AND (uzduotys.Pavadinimas LIKE '%" . $SEARCH_QUERY . "%' OR uzduotys.Uzduoties_id  LIKE '%" . $SEARCH_QUERY . "%') ORDER BY Eiles_nr DESC";    
            }
            $result = $connectM->prepare($queryM);
            $result->execute();
            $number = $result->rowCount(); //paskutines eilus stilizavimui reikalinga
            $i = 1;
            if($number === 0){
                $_SESSION['empty'] = true;
                echo "<span style=\"color: red; margin-left: 73.5%; font-style:italic;\">Tasks with this name or ID do not exist</span";
                ?>
                <div class="div_img">
                <img class="mx-auto d-block" src="empty.png"> 
                </div> 
                <?php

            }
          
            echo "</thead>";
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                if ($i == $number)
                {
                    // spausdinama eilutė su "Sukurti projektą mygtuku
                    echo "

                    <tr>
                        <td class='tasks__td'>" . $row['Uzduoties_id'] . "</td>
                        <td class='tasks__td'>
                        <a href=\"task.php?Projekto_id=" . $row['Uzduoties_id'] . "&title=" . $row['Pavadinimas'] . "&description =" . $row['Aprasymas'] . "&priority =" . $row['Prioritetas'] . "&status=" . $row['Busena'] . "\" class=\"projects__title-hover\">" . $row['Pavadinimas'] . "</td>
                        <td class='tasks__td'>" . $row['Aprasymas'] . "</td>
                        <td class=\"tasks__td tasks__priority-" . $row['Prioritetas'] . "\"\">" . $row['Prioritetas'] . "</td>
                        <td class='tasks__td'>" . $row['Busena'] . "</td>
                        <td class='tasks__td'>" . $row['Sukurimo_data'] . "</td>
                        <td class='tasks__td'>" . $row['Naujinimo_data'] . "</td>
                        <td class='tasks__td'>
                            <button class=\"update1-project__JS\">
                                <i class='far fa-edit '></i>
                            </button>

                            <button class=\"delete-project__JS\" id=\"" . $row['Uzduoties_id'] . "\">";

                            if (isset($_COOKIE['Projekto_id']) && isset($_COOKIE['Projektas'])){
                                echo "<button class=\"delete1-project__JS\" data-id= \"" . $_COOKIE['Projekto_id'] . "\" data-title=\"" . $_COOKIE['Projektas'] . "\" id=\"" . $row['Uzduoties_id'] . "\">";
                                } else {
                                echo "<button class=\"delete1-project__JS\" data-id= \"" . $_GET['Projekto_id'] . "\" data-title=\"" . $_GET['title'] . "\" id=\"" . $row['Uzduoties_id'] . "\">";
                                }
                                echo "

                                <i class='far fa-trash-alt '></i>
                            </button>
                            <button class=\"button\">
                                <i class='fas fa-arrow-down '></i>
                            </button>
                            <button class=\"button\" id='create-button' style='padding: 0;'>
                                <i class='fas fa-plus-circle create-task__JS ' id='plus-button' style=\"bottom: -2.75rem; right: -2rem;\"></i>
                            </button>
                        </td>
                    </tr>";
                                break;
                            }
                            // spausdinamos kitos lentelės eilutės
                            echo "
                    <tr class='tasks__tr--border-bottom'>
                        <td class='tasks__td'>" . $row['Uzduoties_id'] . "</td>
                        <td class='tasks__td'><a href=\"task.php?Projekto_id=" . $row['Uzduoties_id'] . "&title=" . $row['Pavadinimas'] . "&description =" . $row['Aprasymas'] . "&priority =" . $row['Prioritetas'] . "&status=" . $row['Busena'] . "\">" . $row['Pavadinimas'] . "</td>
                        <td class='tasks__td'>" . $row['Aprasymas'] . "</td>
                        <td class=\"tasks__td tasks__priority-" . $row['Prioritetas'] . "\">" . $row['Prioritetas'] . "</td>
                        <td class='tasks__td'>" . $row['Busena'] . "</td>
                        <td class='tasks__td'>" . $row['Sukurimo_data'] . "</td>
                        <td class='tasks__td'>" . $row['Naujinimo_data'] . "</td>
                        <td class='tasks__td'>
                            <button class=\"update1-project__JS\">
                                <i class='far fa-edit '></i>
                            </button>

                            <button class=\"delete-project__JS\" id=\"" . $row['Uzduoties_id'] . "\">";

                            if (isset($_COOKIE['Projekto_id']) && isset($_COOKIE['Projektas'])){
                            echo "<button class=\"delete1-project__JS\" data-id= \"" . $_COOKIE['Projekto_id'] . "\" data-title=\"" . $_COOKIE['Projektas'] . "\" id=\"" . $row['Uzduoties_id'] . "\">";
                            } else {
                            echo "<button class=\"delete1-project__JS\" data-id= \"" . $_GET['Projekto_id'] . "\" data-title=\"" . $_GET['title'] . "\" id=\"" . $row['Uzduoties_id'] . "\">";
                            }
                            echo "
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
                if (isset($_SESSION['empty']) && isset($_GET['title'])) {
                    echo "
        <button id='create-button' class=\"tasks__add-btn\">
            <i class='fas fa-plus-circle create-project__JS tasks__add-btn-i' id='plus-button'></i>
        </button>";

                    unset($_SESSION['empty']);
                }

//Pridedamas html blur'as, jei nesekminga uzklausa ('toks pavadinimas jau yra' ir t.t.)
                echo isset($_POST['title']) ? '<div class="blur__JS"></div>' : '';
                ?>

                <div class="pop-up <?php echo isset($_POST['title']) ? 'pop-up__JS' : ''; ?>">
                    <h2 class="pop-up__h2">Create a new task</h2>
                    <form method="POST" class="pop-up__form">

                        <!-- Task title -->
                        <input style="text-align:left;" class="pop-up__input" type="text" maxlength="30" name="taskTitle" placeholder="Task title" 
                               onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task title'" required>

                        <!-- Task description -->
                        <label for="description" class="pop-up__placeholder">Description</label><textarea class="pop-up__textarea" maxlength="50" name="taskDescription" rows="6"></textarea>


                        <div class="task_insert">


                            <!-- Task priority -->
                            <input class="pop-up__input" id="radioLow" type="radio" value="Low" name="taskPriority" placeholder="Task priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" checked>
                            <label for="radioLow">Low</label>

                            <input class="pop-up__input" id="radioMedium" type="radio" value="Middle" name="taskPriority" placeholder="Task priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" >
                            <label for="radioMedium">Middle</label>

                            <input class="pop-up__input" id="radioHight" type="radio" value="High" name="taskPriority" placeholder="Task priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" >
                            <label for="radioHight">High</label>
                        </div>

                        <!-- Task status -->

                        <div  class="task_status">
                            <!-- Task priority -->

                            <input class="pop-up__input" id="radioTodo" type="radio" value="To do" name="taskStatus" placeholder="Task status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" checked>
                            <label for="radioTodo">To do</label>
                            
                             <input class="pop-up__input" id="radioInProgress" type="radio" value="In Progress" name="taskStatus" placeholder="Task status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'">
                            <label for="radioInProgress" style="width: auto">In Progress</label>

                            <input class="pop-up__input" id="radioFinished" type="radio" value="Finished" name="taskStatus" placeholder="Task status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" >
                            <label for="radioFinished">Finished</label>
                        </div>



                        <!-- Task button -->
                        <div class="pop-up--flex">
                            <input type="submit" name="create" value="Create" class="pop-up__create-btn pop-up__input" id="project-btn">
                            <div role="button" class="pop-up__cancel-btn">Cancel</div>
                        </div>
  </form>
                </div>
                        <?php
                        if (isset($_POST['taskTitle'])) {
                            $create = new Project();
                            $create->createTask($_POST['taskTitle'], $_POST['taskDescription'], $_POST['taskPriority'], $_POST['taskStatus'], $_SESSION['taskId']);
                        }
                        if (isset($_SESSION['message'])) {
                            echo "<p class='pop-up__error'>" . $_SESSION['message'] . "</p>";
                            unset($_SESSION['message']);
                        }
                        ?>
                  
                  <div class="pop-up__update1">
                    <h2 class="pop-up__h2">Update Task</h2>
                    <form method="POST" class="pop-up__form">
                        <input style="text-align:left;" class="pop-up__input pop-up__update-title1" type="text" name="updateTitle" placeholder="Task Title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task Title'" required>


                        <textarea class="pop-up__textarea pop-up__update-description1" placeholder="Description" name="updateDescription" rows="2"></textarea>
                        <input type="hidden" class="pop-up__update-id1" name="updateId"/>
                        
                        
                                  <div class="task_insert">


                            <!-- Task priority -->
                            <input style="display: none"class="pop-up__inputs pop-up__update-priority" id="radioLow11" type="radio" value="Low" name="updatepriority" placeholder="Task Priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" required >
                            <label style="display: none" for="radioLow11">Low</label>

                            <input class="pop-up__inputs pop-up__update-priority" id="radioLow1" type="radio" value="Low" name="updatepriority" placeholder="Task Priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" required >
                            <label  for="radioLow1">Low</label>

                            <input class="pop-up__inputs pop-up__update-priority" id="radioMedium1" type="radio" value="Middle" name="updatepriority" placeholder="Task Priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'" required>
                            <label for="radioMedium1">Middle</label>

                            <input class="pop-up__inputs pop-up__update-priority" id="radioHight1" type="radio" value="High" name="updatepriority" placeholder="Task Priority" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task priority'"required >
                            <label for="radioHight1">High</label>
                        </div>

                        <!-- Task status -->

                         <div  class="task_status">
                            <!-- Task priority -->

                            <input style="display: none" class="pop-up__inputs pop-up__update-status" id="radioTodo11" type="radio" value="To do" name="updatestatus" placeholder="Task Status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" required >
                            <label style="display: none"  for="radioTodo11">To do</label>

                            <input  class="pop-up__inputs pop-up__update-status" id="radioTodo1" type="radio" value="To do" name="updatestatus" placeholder="Task Status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" required >
                            <label   for="radioTodo1">To do</label>

                             <input class="pop-up__inputs pop-up__update-status" id="radioInProgress1" type="radio" value="In Progress" name="updatestatus" placeholder="Task Status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" required>
                            <label for="radioInProgress1" style="width: auto">In Progress</label>

                            <input class="pop-up__inputs pop-up__update-status" id="radioFinished1" type="radio" value="Finished" name="updatestatus" placeholder="Task Status" 
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Task status'" required>
                            <label for="radioFinished1">Finished</label>
                        </div>
                        
                        
                        
                        
                        <div class="pop-up--flex">
                            <input type="submit" name="update" value="Update" class="pop-up__update-btn pop-up__input" id="project-btn">
                            <div role="button" class="pop-up__cancel-btn1">Cancel</div>
                        </div>
                        <?php
                        if (isset($_POST['updateTitle'])) {
                            $update = new Project();
                            $update->updateProject1($_POST['updateTitle'], $_POST['updateDescription'], $_POST['updatepriority'], $_POST['updatestatus'], $_POST['updateId'], $_GET["Projekto_id"], $_GET["title"]);
                        }
                        if (isset($_SESSION['updateError'])) {
                            //   echo "<p class='pop-up__error'>".$_SESSION['updateError']."</p>";
                            echo $_POST['updateId'];
                            unset($_SESSION['updateError']);
                        }
                        ?>
                    </form>
                </div>


                <div class="pop-up__delete1">
                    <h2 class="pop-up__h2">Delete a Task</h2>
                    <form method="POST" class="pop-up__form">
                        <p class="pop-up__alert-msg">Are you sure you want to delete this task?</p>
                        <div class="pop-up--flex">
                            <a href="#" class="pop-up__confirm-btn1">Delete</a>
                            <div role="button" class="pop-up__cancel-btn1 pop-up__cancel-btn--bg">Keep</div>
                        </div>
                    </form>
                </div>


            </main>
            <script src="./js/createProject.js?rnd=132"></script>
        </section>
    </body>


</html>