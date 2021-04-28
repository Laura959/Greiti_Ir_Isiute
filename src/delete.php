<?php
include "db_config.php";





try {
     $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



     /*sql to delete a record*/
        $sql = "DELETE FROM komandos WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; DELETE FROM projektu_uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; DELETE FROM projektai WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; DELETE FROM uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";

    /*use exec() because no results are returned*/
    $conn->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "
" . $e->getMessage();
    }



$conn = null;




?>
 <div><?php if(isset($message)) { echo $message; } ?>
        </div>
        <div style="padding-bottom:5px;">
            <a href="main.php">Project List</a>
        </div>
