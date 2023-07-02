<?php
    session_start();
    if(isset($_SESSION['user'])){
        
         if($_SESSION['user']->role === 'admin'){
             echo"<dive style=\"color:blue; \"> welcome ". $_SESSION['user']->name ." </div>";
             echo '<br><a href="search.php"> users management </a>';
             echo '<br><a href="profile.php"> update profile </a>';
             echo "<form><button type='submit' name='logout'>logout</button></form>";
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
    
    if(isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location:http://localhost/practice/logIn_app/login.php");
    }

?>