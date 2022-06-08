<?php
    session_start();
    if(isset($_SESSION['id'])){
        $idSession = $_SESSION['id'];
        $emailSession = $_SESSION['email'];
        $roleSession = $_SESSION['user_role_id'];

        if($roleSession !== 1) {
            header('location: login.php?error=invalidlogin');
            die();
        }
    } else {
        
    }