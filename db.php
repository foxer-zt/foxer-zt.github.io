<?php
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);             
  $photoIds = array_filter(explode(';', file_get_contents('https://poacher-knock-48467.bitballoon.com/photoids.txt')));
  foreach ($photoIds as &$id) {
    $id = "($id)";
  }
  $query ='INSERT INTO photoIds VALUES ' . implode(', ', $photoIds);
  $dbh->exec($query);
  echo "New record created successfully";
  
} catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}


