<?php session_start();
include "db_config.php";

try {
    $conn = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    
    $ivykis = 'Project / Delete';
    $naujinimas = date("Y-m-d H:i:s");
    
    try{
        $sql = "DELETE FROM komandos WHERE Projekto_id='" . $_GET["Projekto_id"] ."'";
        $sql2 = "DELETE FROM projektu_uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";

        $sql3 = "DELETE FROM projektai WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";
        $sql4 = "DELETE FROM uzduotys WHERE Projekto_id='" . $_GET["Projekto_id"] . "'";
        
       
        $sql5 = "INSERT INTO history VALUES (?,?,?,?,?,?)";
        
        $pav = "???";
        

        $conn->exec($sql);
        $conn->exec($sql2);
        $conn->exec($sql3);
        $conn->exec($sql4);
        $conn->commit();
        
        $statement2 = $conn->prepare($sql5);
         $statement2->execute(['',$ivykis,$pav, $naujinimas, $_SESSION['userId'], $_SESSION['username']]);
        
        // echo "<script> location.replace(\"task.php\"); </script>";
        header('Location: main.php');
    }catch(Exception $e){
        $conn->rollBack();
        $_SESSION['message'] =  "Database connection lost.";
        $_SESSION['message'] =  "";
        echo $e;
        // header('Location: main.php');
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