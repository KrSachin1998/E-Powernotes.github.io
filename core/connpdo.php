<?php 
try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "enotebook";
  
    $dsn= "mysql:host=$servername;dbname=$dbname";
    $conn = new PDO($dsn,$username, $password);
 
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}




?>