<?php
    class Project extends Dbh{
        // private $host = "localhost_db";  
        // private $pass = "nera";
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
        public function createTask($name, $description, $priority, $status){
            if(empty($name)){
                $_SESSION['message'] = "Project's title field is required";
                return;
            }
            if($result = $this->checkIfTaskNameExists($name, $_GET['Projekto_id'])){
                if($result === "error"){
                    $_SESSION['message'] = "Database connection lost.";
                }else{
                    $_SESSION['message'] = "Project with this name already exists";
                }
            }else{
                $id = $this->getUniqueId();
                $date = date("Y-m-d");
                if (isset($_GET['Projekto_id'])) {
                $projektas = $_GET['Projekto_id'];
                } else {
                    $projektas = $_COOKIE['Projekto_id']; 
                }
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                try{
                   $sql = "INSERT INTO uzduotys (`Uzduoties_id`, `Pavadinimas`, `Aprasymas`, `Prioritetas`, `Busena` ,`Sukurimo_data`, `Naujinimo_data`, `Projekto_id`) VALUES (?, ?, ?, ?, ? ,?, ?, ?)";
                   $sql2 = "INSERT INTO projektu_uzduotys VALUES (?, ?)";
                    $statement = $pdo->prepare($sql);
                      $statement->execute([$id, $name, $description, $priority, $status, $date, $date, $projektas]);
                   $statement2 = $pdo->prepare($sql2);
                   $statement2->execute([$projektas, $id]);
                    $pdo->commit();
                    
                    echo "<script> location.replace(\"task.php?Projekto_id=".$projektas."&title=".$name."\"); </script>";
                }catch(Exception $e){
                    $pdo->rollBack();
                    $_SESSION['message'] =  "Database connection lost.";
                }
            }
        }

        public function checkIfTaskNameExists($name, $projectid){
            $sql = "
            SELECT uzduotys.Uzduoties_id FROM uzduotys 
	            INNER JOIN projektu_uzduotys ON uzduotys.Uzduoties_id = projektu_uzduotys.Uzduoties_id 
                INNER JOIN projektai ON projektu_uzduotys.Projekto_id = projektai.Projekto_id 
                WHERE projektai.Projekto_id = ? && uzduotys.Pavadinimas = ?
            ";
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $statement = $pdo->prepare($sql);
                $statement->execute([$projectid, $name]);
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

        public function updateProject1($name, $description1, $priority, $busena, $id1,$projectid,$projecttitle, $page){
        if(empty($name)){
                $_SESSION['updateError'] = "Project's title field is required";
                return;
            }
            try{
                $naujinimas = date("Y-m-d");
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE uzduotys SET Pavadinimas = ?,Prioritetas =?,Busena = ?,Aprasymas = ?, Naujinimo_data = ? WHERE Uzduoties_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute([$name,$priority,$busena, $description1, $naujinimas, $id1]);
                echo "<script> location.replace(\"".$page."?title=".$projecttitle."&Projekto_id=".$projectid."\"); </script>";
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
             public function checkIfNameExistsTask($name, $user){
            $sql = "
            SELECT Pavadinimas FROM uzduotys 
                INNER JOIN komandos ON uzduotys.Uzduoties_id = komandos.Projekto_id 
                INNER JOIN vartotojai ON komandos.Vartotojas = vartotojai.Vartotojo_id 
                WHERE uzduotys.Pavadinimas = ? && vartotojai.Vartotojo_id = ?
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
        public function getUserId($email){
            $sql = "SELECT Vartotojo_id From vartotojai WHERE El_pastas = ?;";
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $statement = $pdo->prepare($sql);
                $statement->execute([$email]);
               
                if($row = $statement->fetch()){
                    return $row['Vartotojo_id'];
                }else{
                    return false;
                }
            }catch(PDOException $error){
                return 'error';
            }
        }

        public function existsUserOnProject($projectId, $id){
            $sql = "
            SELECT vartotojai.* FROM vartotojai
                LEFT JOIN komandos ON komandos.Vartotojas = vartotojai.Vartotojo_id
                LEFT JOIN projektai ON projektai.Projekto_id = komandos.Projekto_id
                WHERE projektai.Projekto_id = ?
                AND vartotojai.Vartotojo_id = ?
            ";
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $statement = $pdo->prepare($sql);
                $statement->execute([$projectId, $id]);
               
                if($statement->fetch()){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $error){
                return true;
            }
        }

        public function inviteMember($email){
            $id = $this->getUserId($email);
            $project = $_GET['Projekto_id'];
            if(!$id){
                $_SESSION['inviteError'] = 'User with this email is not registered';
                return;
            }else if($this->existsUserOnProject($project, $id)){
                $_SESSION['inviteError'] = 'User with this email is already on the project';
                return;
            }
            $role = 2;
            $sql = "
            INSERT INTO komandos VALUES(?, ?, ?);
            ";
            try{
                $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
                $pdo = new PDO($dsn, $this->user, $this->pass);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $statement = $pdo->prepare($sql);
                $statement->execute([$project, $role, $id]);
                $count = $statement->rowCount();
                if($count > 0){
                    $name = $_GET['title'];
                    echo "<script> location.replace(\"task.php?Projekto_id=".$project."&title=".$name."\"); </script>";
                    return true;
                }else{
                    $_SESSION['inviteError'] = 'Database connection lost.';
                    return false;
                }
            }catch(PDOException $error){
                $_SESSION['inviteError'] = 'Database connection lost.';
                return 'error';
            }
        }
    }
