<?php  session_start();
include "db_config.php";





try {
    $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    
    $ivykis = 'Task / Delete';
    $naujinimas = date("Y-m-d H:i:s");
    
    try{
        $sql = "DELETE FROM projektu_uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] ."'";
        $sql3 = "DELETE FROM uzduotys WHERE Uzduoties_id='" . $_GET["Uzduoties_id"] . "'";
        
        
         $sql2 = "INSERT INTO history VALUES (?,?,?,?,?,?)";
               
        // $Id = $_GET["Projekto_id"];
        // $title = $_GET["title"];
        $conn->exec($sql);
        $conn->exec($sql3);
        $conn->commit();
        
         $statement2 = $conn->prepare($sql2);
         $statement2->execute(['',$ivykis,$_GET['title'], $naujinimas, $_SESSION['userId'], $_SESSION['username']]);
         
        // echo "<script> location.replace(\"task.php?id=\"); </script>";
        header("Location: task.php?title=".$_GET["title"]."&Projekto_id=".$_GET["Projekto_id"]."");
    
    
    }catch(Exception $e){
        $conn->rollBack();
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
