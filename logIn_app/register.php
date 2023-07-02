<form action="" method="post">
    Name : <input type="text" name="text" required>
    <br>
    Age  : <input type="date" name="date" required>
    <br>
    Email: <input type="email" name="email" required>
    <br>
    Password : <input type="password" name="password" required>
    <br>
    <a href="login.php"> login</a>
    <button type="submit" name="register"> register </button>
</form>

<?php

require_once 'db_conn.php'; # connecting to database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "m_elshaarawy";

// $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

$checkEmail = $conn->prepare("SELECT * FROM users WHERE email=:EMAIL");
if(isset($_POST['register'])){
    $email = $_POST['email'];
    $checkEmail->bindParam("EMAIL",$email);
    $checkEmail->execute();
    if($checkEmail->rowCount()>0){
        echo "<div style=\" color:red; \">email already exist</dev>";
    }else{
        $name = $_POST['text'];
        $age = $_POST['date'];
        $pass = $_POST['password'];
        $register = $conn->prepare("INSERT INTO users(name,age,email,password,role) 
        VALUES(:NAME,:AGE,:EMAIL,:PASS,'user')");
        $register->bindParam("NAME",$name);
        $register->bindParam("AGE",$age);
        $register->bindParam("EMAIL",$email);
        $register->bindParam("PASS",$pass);
        if($register->execute()){
            echo "<div style=\" color:green; \"> successfully registered </dev>";
        }else{
            echo "Error";
        }
  
    }
}
?>