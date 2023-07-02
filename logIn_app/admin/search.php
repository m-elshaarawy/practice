<?php
    session_start();
    if(isset($_SESSION['user'])){

        if($_SESSION['user']->role === 'admin'){
            echo '<form  method="get">
            <input type="search" name="search" placeholder="search..." required>
            <button type="submit" name="searchB"> search </button>
            <a href="index.php"> home</a>
            </form>';

            require_once '../db_conn.php'; # connecting to database

            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "m_elshaarawy";

            // $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);

            if(isset($_GET['searchB'])){

                $SEARCH =$conn->prepare("SELECT * FROM users WHERE name LIKE :Name OR email LIKE :Name");
                $Sresult = '%'.$_GET['search'].'%';
                $SEARCH->bindParam("Name",$Sresult);
                //$SEARCH->bindParam("Email",$Sresult);

                if($SEARCH->execute()){
                    //echo "<div style=\" color:green; \"> successfully updated </dev>";
                    echo '<table>';
                    echo '<tr>';
                    echo '<th> Name </th>';
                    echo '<th> Email </th>';
                    echo '<th> Delete </th>';
                    echo '<th> Edit </th>';
                    echo '</tr>';
                    foreach($SEARCH as $data){
                        echo '<tr>';
                        echo '<td>'.$data['name'].' </td>';
                        echo '<td> : '.$data['email'].' </td>';
                        echo '<td><form><button type="submit" name="delete" value="'.$data['id'].'"> delete</button></form></td>';
                        echo '<td><form><button type="submit" name="edit" value="'.$data['id'].'"> edit</button></form></td>';
                        //echo '<div>'.$data['name']." : ".$data['email'].'</div>';
                        echo '</tr>';
                    }
                    echo'</table>';
                }else{
                    echo "<div style=\" color:red; \">  failed </dev>";
                }
            }

            if(isset($_GET['delete'])){
                    
                $removeItem = $conn->prepare("DELETE FROM todolist  WHERE id=:ID");
                $removeItem->bindParam("ID",$_GET['delete']);
                $removeItem->execute();

                $removeUser = $conn->prepare("DELETE FROM users  WHERE id=:ID");
                $removeUser->bindParam("ID",$_GET['delete']);
                if($removeUser->execute()){
                    echo "<div style=\" color:green; \">  deleted </dev>";
                    header("Refresh: 1 ; url=search.php");
                }else{
                    echo "<div style=\" color:red; \">  failed".$removeItem->errorInfo()." </dev>";
                }
            }

            if(isset($_GET['edit'])){
                $_SESSION['user_id'] =$_GET['edit'];
                header("Location:edit_user.php",true);
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
