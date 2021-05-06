<?php
include "db_config.php";





try {
    $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    try{
        $sql = "DELETE FROM projektu_uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] ."'";
        $sql3 = "DELETE FROM uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] . "'";
        // $Id = $_GET["Projekto_id"];
        // $title = $_GET["title"];
        $conn->exec($sql);
        $conn->exec($sql3);
        $conn->commit();
        // echo "<script> location.replace(\"task.php?id=\"); </script>";
        header("Location: task.php?title=".$_GET["title"]."&Projekto_id=".$_GET["Projekto_id"]."");
    
    
    }catch(Exception $e){
        $pdo->rollBack();
         $_SESSION['message'] =  "Database connection lost.";
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
