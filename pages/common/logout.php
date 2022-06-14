<?php
    // Initialize the session
    session_start();
    
    $_SESSION = array();
    
    // Destroy the session.
    session_destroy();

    $_SESSION['loggedIn'] = false;
    
    // Redirect to login page
    header("location: ../auth/login.php");
    exit;
?>