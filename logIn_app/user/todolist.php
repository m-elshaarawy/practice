

<?php
    session_start();

    if(isset($_SESSION['user'])){
        
        if($_SESSION['user']->role === 'user'){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "m_elshaarawy";
            $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);
            echo '<form action="" method="post">
            <input type="text" name="text" required>
            <button type="submit" name="add">add</button>
            <a href="index.php"> home </a>
            </form>';
            
            if(isset($_POST['add'])){
    
                $addItem =$conn->prepare("INSERT INTO todolist(text,user_id) 
                VALUES(:Text,:Uid)");
                $user_id = $_SESSION['user']->id;
                $addItem->bindParam("Text",$_POST['text']);
                $addItem->bindParam("Uid",$user_id);
                if($addItem->execute()){
                    echo "<div style=\" color:green; \"> successfully added </dev>";
                    header("refresh:2");
                }else{
                    echo "<div style=\" color:red; \"> adding failed </dev>";
                }
                
            }
        
            $toDoItem = $conn->prepare("SELECT * FROM todolist WHERE user_id=:Id");
            $user_id = $_SESSION['user']->id;
            $toDoItem->bindParam("Id",$user_id);
            $toDoItem->execute();
            foreach($toDoItem AS $item){
                echo"<div>".$item['text']."</div>";
            }
            

        }else{
            header("Location:http://localhost/practice/logIn_app/login.php");
            die("");
        }

   }else{
       header("Location:http://localhost/practice/logIn_app/login.php");
       die("");
   }

   

?>

