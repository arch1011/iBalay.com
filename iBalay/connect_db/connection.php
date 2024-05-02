<?php

//installation manual
//configure nalang ddi an credentials salamats
//import first the database sql ha xampp localhost/phpmyadmin

$db_host = 'localhost';      
$db_user = 'root';  
$db_pass = '';  
$db_name = 'ibalay_database'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
