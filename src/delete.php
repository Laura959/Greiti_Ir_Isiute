<?php
include "db_config.php";

try {
    $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    try{
        $sql = "DELETE FROM komandos WHERE Projekto_id='" . $_GET["Projekto_id"] ."'";
        $sql2 = "DELETE FROM projektu_uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";
        $sql3 = "DELETE FROM projektai WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";
        $sql4 = "DELETE FROM uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";
        $conn->exec($sql);
        $conn->exec($sql2);
        $conn->exec($sql3);
        $conn->exec($sql4);
        $conn->commit();
        // echo "<script> location.replace(\"task.php\"); </script>";
        header('Location: main.php');
    }catch(Exception $e){
        $conn->rollBack();
        $_SESSION['message'] =  "Database connection lost.";
        header('Location: main.php');
    }
     /*sql to delete a record*/
    // $sql = "DELETE FROM komandos WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; 
    // DELETE FROM projektu_uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; 
    // DELETE FROM projektai WHERE Projekto_id='" . $_GET["Projekto_id"] . "'; 
    // DELETE FROM uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";

    /*use exec() because no results are returned*/
    // $conn->exec($sql);
    // $conn = null;
    // header('Location: main.php');
    }
catch(PDOException $e)
    {
    echo $sql . "
" . $e->getMessage();
    }