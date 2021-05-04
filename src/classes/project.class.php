<?php
    class Project extends Dbh{

        private $host = "localhost";  
        private $user = "root";  
        private $pass = "";  
        private $dbName = "projektas"; 

        public function createProject($name, $description, $user){
            if(empty($name)){
                $_SESSION['message'] = "Project's title field is required";
                return;
            }
            if($result = $this->checkIfNameExists($name, $user)){
                if($result === "error"){
                    $_SESSION['message'] = "Database connection lost.";
                }else{
                    $_SESSION['message'] = "Project with this name already exists";
                }
            }else{
                $id = $this->getUniqueId();
                $state = 'In Progress';
                $date = date("Y-m-d");
                $role = 1;

                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                try{
                    $sql = "INSERT INTO projektai VALUES (?, ?, ?, ?, ?)";
                    $sql2 = "INSERT INTO komandos VALUES (?, ?, ?)";
                    $statement = $pdo->prepare($sql);
                    $statement->execute([$id, $name, $description, $state, $date]);
                    $statement2 = $pdo->prepare($sql2);
                    $statement2->execute([$id, $role, $user]);
                    $pdo->commit();
                    echo "<script> location.replace(\"task.php?Projekto_id=".$id."&title=".$name."\"); </script>";
                }catch(Exception $e){
                    $pdo->rollBack();
                    $_SESSION['message'] =  "Database connection lost.";
                }
            }
        }

        public function updateProject($name, $description, $id){
            if(empty($name)){
                $_SESSION['updateError'] = "Project's title field is required";
                return;
            }else if(strlen($id) !== 9){
                $_SESSION['updateError'] = "Project ID is invalid";
                return;
            }
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE projektai SET Pavadinimas = ?, Aprasymas = ? WHERE Projekto_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute([$name, $description, $id]);
                echo "<script> location.replace(\"main.php\"); </script>";
            }catch(PDOException $error){
                $_SESSION['updateError'] =  "Database connection lost.";
                $_POST['fail'] = 'set';
            }
        }
        //Generuojamas id iki kol bus gauta unikali reiksme
        public function getUniqueId(){
            $id = rand(100000000, 999999999);
            if($this->checkIfIdExists($id)){
                $this->getUniqueId();
            }
            return $id;
        }

        public function checkIfIdExists($id){
            $sql = "SELECT * FROM projektai WHERE Projekto_id = ?";  
            $statement = $this->connect()->prepare($sql);
            $statement->execute([$id]);
            $count = $statement->rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
            }
        }

        public function checkIfNameExists($name, $user){
            $sql = "
            SELECT Pavadinimas FROM projektai 
                INNER JOIN komandos ON projektai.Projekto_id = komandos.Projekto_id 
                INNER JOIN vartotojai ON komandos.Vartotojas = vartotojai.Vartotojo_id 
                WHERE projektai.Pavadinimas = ? && vartotojai.Vartotojo_id = ?
            ";
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $statement = $pdo->prepare($sql);
                $statement->execute([$name ,$user]);
                $count = $statement->rowCount();
                if($count > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $error){
                return 'error';
            }
        }
    }