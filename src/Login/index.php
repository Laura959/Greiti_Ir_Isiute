<?php  
 session_start();  
 $host = "localhost";  
 $user = "root";  
 $pass = "";  
 $dbName = "task_system";  
 $message = "";  

 try  
 {  
      $connect = new PDO("mysql:host=$host; dbname=$dbName", $user, $pass);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<span>All fields are required</span>';  
           }  
           else  
           {  
                $query = "SELECT * FROM vartotojai WHERE El_pastas = ? AND Slaptazodis = ?";  
                $statement = $connect->prepare($query);  
                $statement->execute([$_POST["username"], $_POST["password"]]);  
                $count = $statement->rowCount();  
                if($count > 0)
                {
                    $statement->setFetchMode(2);
                    $result = $statement->fetchAll();
                    $_SESSION["name"] = $result[0]['Vardas'];
                    header("location:main.php");  
                }  
                else  
                {  
                     $message = 'Invalid username or password';  
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = 'Something went wrong';  
 }  
 ?>  
 <!DOCTYPE html>  
 <html lang="en">  
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta name="description" content="Login page">
          <title>Login</title>
          <link href="css/style.css?rnd=132" type="text/css" rel="stylesheet">
      </head>
      <body>
      <div class="header">
		<h2>Login</h2>
	     </div>
          <form method="POST" id="login-form">
               <label>Email</label>
               <input type="text" name="username" placeholder="Your email" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" title="Enter a valid email address" required>
               <label>Password</label>
               <input type="password" name="password" placeholder="Your password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
               <input type="submit" name="login" value="Login" class="login-btn" id="login-btn"><br>
               <?php
               if(!empty($message))  
                    {  
                         echo '<p class="error">'.$message.'</p><br>';  
                    }
               ?>
        </form>
        </div>
      </body>  
 </html>  
