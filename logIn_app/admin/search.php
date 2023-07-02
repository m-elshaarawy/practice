<?php
    session_start();
    if(isset($_SESSION['user'])){

        if($_SESSION['user']->role === 'admin'){
            echo '<form  method="get">
            <input type="search" name="search" placeholder="search..." require>
            <button type="submit" name="searchB"> search </button>
            <a href="index.php"> home</a>
            </form>';
    
            if(isset($_GET['searchB'])){
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "m_elshaarawy";
    
                $conn = new PDO("mysql: host=$servername;dbname=$dbname",$username,$password);
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
                    echo '</tr>';
                    foreach($SEARCH as $data){
                        echo '<tr>';
                        echo '<td>'.$data['name'].'</td>';
                        echo '<td> : '.$data['email'].' </td>';
                        //echo '<div>'.$data['name']." : ".$data['email'].'</div>';
                        echo '</tr>';
                    }
                    echo'</table>';
                }else{
                    echo "<div style=\" color:red; \">  failed </dev>";
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