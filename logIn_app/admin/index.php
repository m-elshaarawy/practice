<?php
    session_start();
    if(isset($_SESSION['user'])){
        
         if($_SESSION['user']->role === 'admin'){
             echo"<dive style=\"color:blue; \"> welcome ". $_SESSION['user']->name ." </div>";
             echo "<form><button type='submit' name='logout'>logout</button></form>";
         }else{
             header("Location:http://localhost/practice/logIn_app/login.php");
             die("");
         }

    }else{
        header("Location:http://localhost/practice/logIn_app/login.php");
        die("");
    }
    
    if(isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location:http://localhost/practice/logIn_app/login.php");
    }

?>