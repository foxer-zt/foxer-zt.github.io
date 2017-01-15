<?php 

if (!isset($_REQUEST)) { 
  return; 
} 
$confirmation_token = 'f3de3c4e'; 
$token = '1042eda5d74788e33e9d30a26392b333669169050edd86f60181752309c1bba4577bc7ec87c32a2645f11'; 
$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) { 
  case 'confirmation': 
    echo $confirmation_token; 
    break; 

  case 'message_new': 
    $user_id = $data->object->user_id; 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 
    $user_name = $user_info->response[0]->first_name;
    $catApiUrl = 'http://thecatapi.com/api/images/get?format=xml';
    $xml = simplexml_load_string(file_get_contents($catApiUrl), "SimpleXMLElement", LIBXML_NOCDATA);
    $response = json_decode(json_encode($xml), true);
    $catUrl = $response['data']['images']['image']['url'];
    $request_params = array( 
      'message' => "Привет, {$user_name}!\nМы обязательно тебе ответим, ну а пока держи котика :3\n$catUrl", 
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.0' 
    ); 

  $get_params = http_build_query($request_params); 
  file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
  echo('ok'); 
  break; 
} 
