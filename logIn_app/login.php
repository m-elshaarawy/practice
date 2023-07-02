<form action="" method="post">
    Email: <input type="email" name="email" require>
    password: <input type="password" name="password" require>
    <a href="register.php"> register</a>
    <button type="submit" name="login">login</button>
</form>

<?php

require_once 'db_conn.php'; # connecting to database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "m_elshaarawy";

// $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

$login = $conn->prepare("SELECT * FROM users WHERE email=:EMAIL AND password =:PASS");

if(isset($_POST['login'])){

  $login->bindParam("EMAIL",$_POST['email']);
  $login->bindParam("PASS",$_POST['password']);
  $login->execute();

  if($login->rowCount() === 1){
      $u_data = $login->fetchObject();
    echo"<dive style=\"color:blue; \"> welcome $u_data->name </div>";
    session_start();
    $_SESSION['user']=$u_data;
    
    if($u_data->role === 'admin'){
      header("Location: admin/index.php");
    }elseif($u_data->role === 'user'){
      header("Location: user/index.php");
    }


  }else{
    echo"<dive style=\"color:red; \"> wrong email or password </div>";
  }



}

?>