

<?php
    session_start();

    if(isset($_SESSION['user'])){
        
        if($_SESSION['user']->role === 'user'){

            require_once '../db_conn.php'; # connecting to database

            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "m_elshaarawy";
            // $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

            echo '<form action="" method="post">
            <input type="text" name="text" required>
            <button type="submit" name="add">add</button>
            <a href="index.php"> home </a>
            </form>';
            
            if(isset($_POST['add'])){
    
                $addItem =$conn->prepare("INSERT INTO todolist(text,user_id,status) 
                VALUES(:Text,:Uid,0)");
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
            echo'<table>';
            echo'<tr>';
            echo'<th>task</th>';
            echo'<th>status</th>';
            echo'<th>delete</th>';
            echo '</tr>';
            foreach($toDoItem AS $item){
                echo'<tr>';
                echo'<td>'.$item['text'].'</td>';
                if($item['status'] === 0){
                    echo'<td><form ><button style="color:red" type="submit" name="status" value="'.$item['id'].'">waiting</button></form></td>';
                }elseif($item['status'] === 1){
                    echo'<td><form ><button style="color:green" type="submit" name="status" value="'.$item['id'].'">done</button></form></td>';
                }
                
                echo'<td><form><button type="submit" name="delete" value="'.$item['id'].'">delete'.$item['id'].'</button></form></td>';
                echo '</tr>';  
            }
            echo'</table>';

            if(isset($_GET['status'])){
                if($item['status'] === 0){
                    $updateStatus = $conn->prepare("UPDATE todolist SET status=1 WHERE id=:ID");
                    $updateStatus->bindParam("ID",$_GET['status']);
                    $updateStatus->execute();
                    header("Location:todolist.php",true);
                    //header("refresh:2",true);

                }elseif($item['status'] === 1){
                    $updateStatus = $conn->prepare("UPDATE todolist SET status=0 WHERE id=:ID");
                    $updateStatus->bindParam("ID",$_GET['status']);
                    $updateStatus->execute();
                    header("Location:todolist.php",true);
                }
            }

            if(isset($_GET['delete'])){
                $removeItem = $conn->prepare("DELETE FROM todolist  WHERE id=:ID");
                $removeItem->bindParam("ID",$_GET['delete']);
                $removeItem->execute();
                header("Location:todolist.php",true); 

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

