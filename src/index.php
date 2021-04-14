<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Aldrich&display=swap" rel="stylesheet">
        <title>PARDĖ</title>
    </head>
    <body>
			<div class="header">
		<h2>Login</h2>
	</div>
        <form action="index.php"method="POST">
					<div class="input-group">
						<label>Vartotojo Vardas</label>
						<input type="text" name="Username" placeholder="Iveskite gmail" >
					</div>
					<div class="input-group">
						<label>Splatazodis</label>
						<input type="password" name="passwordas" placeholder="Iveskite Slaptazodi">
					</div>
            <input type="submit" name="login" value="login"><br>

            <?php
session_start();

$dbhost= "localhost";
$dbuser= "root";
$dbpass= "";
$dbname= "shop";//Savo db varda ideti gali



if(!$conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)){


{

        die("failed to connect!");
    }

}


    if($_SERVER['REQUEST_METHOD']== "POST")
    {

      $username=$_POST['Username'];
      $pwd=$_POST['passwordas'];

      if(!empty($username) && !empty($pwd))
      {
          //Skaito is db/

          $query ="select * from vartotojai1 where Vardas='$username' limit 1";
          $result= mysqli_query($conn, $query);

          if($result)
          {
               if($result && mysqli_num_rows($result)> 0)
     {
              $user_data=mysqli_fetch_assoc($result);

                  if($user_data['Slaptazodis']===$pwd)
              {
                      $_SESSION['Username']= $user_data['Username'];
                      header("Location: index1.php");
                          die;

          }
          else {
            echo "Neteisingas Slaptazodis";
          }
          }
          else {
            echo "Neteisingas Vartotojo Vardas";
          }
          }

          }else
          {
              echo "<br>Uzpildykite visus langelius";
          }
  }


?>
        </form>
    </div>
    </body>
</html>
