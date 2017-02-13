<?php
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e){
    die($query . "<br>" . $e->getMessage());
}


