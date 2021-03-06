<?php 
    
    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);
    
    // requirements
    require("helpers.php");
    
    //session files directory path
    session_save_path('../session_data');
    
    //enable sessions
    session_start();
    
    // require authentication for all pages except /login.php, /logout.php, /register.php , /index.php , /store.php , /search.php , /items.php
    if (!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php","/index.php","/store.php","/search.php","/items.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
