<?php 

if (!isset($_REQUEST)) { 
  return; 
} 
$confirmation_token = 'f3de3c4e'; 
$token = '1042eda5d74788e33e9d30a26392b333669169050edd86f60181752309c1bba4577bc7ec87c32a2645f11'; 
$data = json_decode(file_get_contents('php://input')); 
$commands = [
  '!cat' => 'cat',
  '!youtube' => 'youtube'
];


switch ($data->type) { 
  case 'confirmation': 
    echo $confirmation_token; 
    break; 

  case 'message_new': 
    $user_id = $data->object->user_id; 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 
    $user_name = $user_info->response[0]->first_name;
    $message = "Привет, $user_name!\n Да прибудет с тобой сила!\nСписок доступных комманд:\n" . implode(', ', array_keys($commands));
    foreach($commands as $command => $function) {
      if (strpos($data->object->body, $command) !== false && function_exists($function)) {
        $message = $function($data->object->body);
      }
    }
    $request_params = array( 
      'message' => $message,
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.62' 
    ); 

  $get_params = http_build_query($request_params); 
  file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
  echo('ok'); 
  break; 
}

function youtube($text) 
{
    preg_match('@!youtube\s(.*)@', $text, $matches);
    $matches = array_filter($matches);
    if (!isset($matches[1]) ) {
      return "Введите запрос. Например: !youtube котики";
    } else {
      $youtubeManager = 'https://irishdash.herokuapp.com/youtube.php?q=' . $matches[1];
      $videoIds = json_decode(file_get_contents($youtubeManager), true);
      $randomId = array_rand($videoIds);
      return count($videoIds) 
        ? "По вашему запросу '{$matches[1]}' мы нашли:\nhttps://www.youtube.com/watch?v=" . $videoIds[$randomId]
        : "По вашему запросу '{$matches[1]}' мы ничего ненашли :(";
    }
}

function cat($text)
{
    $catApiUrl = 'http://thecatapi.com/api/images/get?format=xml&api_key=MTUwMjE2';
    $xml = simplexml_load_string(file_get_contents($catApiUrl), "SimpleXMLElement", LIBXML_NOCDATA);
    $response = json_decode(json_encode($xml), true);
    return "Держи котика, няша :3\n" . $response['data']['images']['image']['url'];
}
