<?php
    session_start();
    if(isset($_SESSION['user'])){

        if($_SESSION['user']->role === 'user'){
            echo '<form action="" method="post">
            Name : <input type="text" name="text" value="'.$_SESSION['user']->name.'" required>
            <br>
            Age  : <input type="date" name="date" value="'.$_SESSION['user']->age.'" required>
            <br>
            Password : <input type="password" name="password" value="'.$_SESSION['user']->password.'" required>
            <br>
            <a href="index.php"> home</a>
            <button type="submit" name="update" value="'.$_SESSION['user']->id.'"> update </button>
            </form>';
    
            if(isset($_POST['update'])){

                require_once '../db_conn.php'; # connecting to database
                // $servername = "localhost";
                // $username = "root";
                // $password = "";
                // $dbname = "m_elshaarawy";
    
                // $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

                $update =$conn->prepare("UPDATE users SET name=:Name , age=:Age , password=:Pass WHERE id=:Id");
                $update->bindParam("Name",$_POST['text']);
                $update->bindParam("Age",$_POST['date']);
                $update->bindParam("Pass",$_POST['password']);
                $update->bindParam("Id",$_POST['update']);
                if($update->execute()){
                    echo "<div style=\" color:green; \"> successfully updated </dev>";
                    $user = $conn->prepare("SELECT * FROM users WHERE id=:Id");
                    $user->bindParam("Id",$_POST['update']);
                    $user->execute();
                    $_SESSION['user']=$user->fetchObject();
                    header("refresh:2");
                }else{
                    echo "<div style=\" color:red; \"> update failed </dev>";
                }
            }
        }else{
            session_unset();
            session_destroy();
            header("Location:http://localhost/practice/logIn_app/login.php");
        }
    }else{
        session_unset();
        session_destroy();
        header("Location:http://localhost/practice/logIn_app/login.php");
    }

?>

