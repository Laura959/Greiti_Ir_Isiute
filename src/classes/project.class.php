<?php

    class Project extends Dbh{

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
                $id = $this->getRandomId();
                $state = 'In Progress';
                $date = date("Y-m-d");
                $role = 1;
                $sql = "INSERT INTO projektai VALUES (?, ?, ?, ?, ?)";
                $sql2 = "INSERT INTO komandos VALUES (?, ?, ?)";
                $statement = $this->connect()->prepare($sql);
                $statement->execute([$id, $name, $description, $state, $date]);
                $statement2 = $this->connect()->prepare($sql2);
                $statement2->execute([$id, $role, $user]);
                //Jei abi uzklausos sekmingos kiekvienos ju rowCount() bus po 1
                if($statement->rowCount() + $statement2->rowCount() === 2){
                    echo "<script> location.replace(\"task.php\"); </script>";
                }else{
                    // $_SESSION['message'] =  "Database connection lost.";
                    // $_SESSION['message'] = $user."role: ".$role."id: ".$id;
                    $_SESSION['message'] = $statement2->rowCount();
                }
            }
        }
        //Generuojamas id iki kol bus gauta unikali reiksme
        public function getRandomId(){
            $id = rand(100000000, 999999999);
            if($this->checkIfIdExists($id)){
                $this->getRandomId();
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
            // Connection ne per dbh.class.php, nes kol kas neradau kaip reikia pagauti (catch) error tokiu atveju
            $host = "localhost";
            $dbUser = "root";
            $pass = "";
            $dbName = "projektas";

            try{
                $dsn = "mysql:host=".$host.";dbname=".$dbName;
                $pdo = new PDO($dsn, $dbUser, $pass);
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