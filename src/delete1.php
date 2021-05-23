<?php
include "db_config.php";





try {
    $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    try{
        $sql = "DELETE FROM projektu_uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] ."'";
        $sql3 = "DELETE FROM uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] . "'";
        $conn->exec($sql);
        $conn->exec($sql3);
        $conn->commit();
        // echo "<script> location.replace(\"task.php?id=\"); </script>";
        header("Location: task.php?title=".$_GET["title"]."&Projekto_id=".$_GET["Projekto_id"]."");
    
    
    }catch(Exception $e){
        $pdo->rollBack();
         $_SESSION['message'] =  "Database connection lost.";
    }
    }
catch(PDOException $e)
    {
    echo $sql . "
" . $e->getMessage();
    }
