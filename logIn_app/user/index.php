<?php
    session_start();
    if(isset($_SESSION['user'])){
        
         if($_SESSION['user']->role === 'user'){
             echo"<dive style=\"color:blue; \"> welcome ". $_SESSION['user']->name ." </div>";
             echo '<br><a href="todolist.php"> todolist </a>';
             echo '<br><a href="profile.php"> update profile </a>';
             echo "<form><button type='submit' name='logout'>logout</button></form>";
         }else{
             header("Location:http://localhost/practice/logIn_app/login.php");
             die("");
         }

    }else{
        header("Location:http://localhost/practice/logIn_app/login.php");
        die("");
    }



?>