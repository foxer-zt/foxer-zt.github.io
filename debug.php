<?php
$catApiUrl = 'http://thecatapi.com/api/images/get?format=xml';
$xml = simplexml_load_string(file_get_contents($catApiUrl), "SimpleXMLElement", LIBXML_NOCDATA);
$response = json_decode(json_encode($xml), true);
$catUrl = $response['data']['images']['image']['url'];
echo "<img src='$catUrl'>";
