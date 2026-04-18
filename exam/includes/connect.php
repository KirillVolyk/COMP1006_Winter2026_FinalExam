<?php 

$host = "localhost"; //hostname
$db = "image_gallery"; //database name
$user = "root"; //username
$password = ""; //password

// same thng but for live server
// $host = "172.31.22.43"; //hostname
// $db = "Kirill200638948"; //database name
// $user = "Kirill200638948"; //username
// $password = "gla4Z4boty"; //password

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}