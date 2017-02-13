<meta charset="windows-1252">
<?php
if (!isset($_GET['random'])) {
  die('Missed "random" key. Available values: quote, photoId');
}
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->prepare('SELECT * FROM :table ORDER BY RAND() LIMIT 1');
  $dbh->bindParam(':table', $_GET['random'] . 's');
  $result = $dbh->execute();
  var_dump($result);
  var_dump($_GET['random']);
  echo $result[0][$_GET['random']];
  $dbh = null;
} catch(PDOException $e){
    die($query . "<br>" . $e->getMessage());
}


