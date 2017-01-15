<?php
$catApiUrl = 'http://thecatapi.com/api/images/get?format=xml';
$xml = simplexml_load_string(file_get_contents($catApiUrl), "SimpleXMLElement", LIBXML_NOCDATA);
$response = json_decode(json_encode($xml), true);
var_dump($response);

//echo "<img src='$carApiUrl'>";
