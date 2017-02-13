<meta charset="windows-1252">
<?php
$tables = ['quote', 'photoId'];
if (!isset($_GET['random']) || !in_array($_GET['random'], $tables)) {
  die('Missed "random" key. Available values: ' . implode(', ', $tables));
}
$table = $_GET['random'] . 's';
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $data = $dbh->query("SELECT * FROM $table ORDER BY RAND() LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);  
  echo $data[0][$_GET['random']];
  $dbh = null;
} catch(PDOException $e){
    die($query . "<br>" . $e->getMessage());
}


