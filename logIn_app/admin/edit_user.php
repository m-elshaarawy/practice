<?php
    session_start();
    if(isset($_SESSION['user'])){

        if($_SESSION['user']->role === 'admin'){

            require_once '../db_conn.php'; # connecting to database

            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "m_elshaarawy";

            // $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

            if(isset($_SESSION['user_id'])){
                $user = $conn->prepare("SELECT * FROM users WHERE id=:ID");
                $user->bindParam("ID",$_SESSION['user_id']);
                $user->execute();
                $user=$user->fetchObject();

                echo '<form action="" method="post">
                Name : <input type="text" name="text" value="'.$user->name.'" required>
                <br>
                Age  : <input type="date" name="date" value="'.$user->age.'" required>
                <br>';
                echo'Status :<select name="activate" >';
                if($user->activate === 1){
                    echo'<option value="'.$user->activate.'">Active</option>';
                }else{
                    echo'<option value="'.$user->activate.'">InActive</option>';
                }
                echo'<option value="0">InActive</option>
                <option value="1">Active</option>
                </select>
                <br>
                <a href="index.php"> home</a>
                <button type="submit" name="update" value="'.$user->id.'"> update </button>

                </form>';

            }

            if(isset($_POST['update'])){
                $update = $conn->prepare("UPDATE users SET name=:Name, age=:Age , activate=:Act WHERE id=:ID");
                $update->bindParam("ID",$_SESSION['user_id']);
                $update->bindParam("Name",$_POST['text']);
                $update->bindParam("Age",$_POST['date']);
                $update->bindParam("Act",$_POST['activate']);
                $update->execute();
                echo "<div style=\" color:green; \">  successfully updated </dev>";
                header("Refresh:1;url=edit_user.php");

            }






        }else{
            session_unset();
            session_destroy();
            header("Location:http://localhost/practice/logIn_app/login.php");
            die("");
        }
    }else{
        session_unset();
        session_destroy();
        header("Location:http://localhost/practice/logIn_app/login.php");
        die("");
    }
    ?>

