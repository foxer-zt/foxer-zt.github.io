<?php
//создаем функции, которые будут отсылать боту все необходимые данные
class XORFUNC
{
 public static function XOR_encrypt($message, $key)
 {
 $ml = strlen($message);
 $kl = strlen($key);
 $newmsg = "";

 for ($i = 0; $i < $ml; $i++) {
 $newmsg = $newmsg . ($message[$i] ^ $key[$i % $kl]);
 }

 return base64_encode($newmsg);
 }

 public static function XOR_decrypt($encrypted_message, $key)
 {
 $msg = base64_decode($encrypted_message);
 $ml = strlen($msg);
 $kl = strlen($key);
 $newmsg = "";

 for ($i = 0; $i < $ml; $i++) {
 $newmsg = $newmsg . ($msg[$i] ^ $key[$i % $kl]);
 }
 return $newmsg;
 }
}

//настройки бота, нам понадобиться лишь один параметр - id бота, его можно узнать, просто наведя мышку на своего бота или чужого бота в сервисе.
$config['botid'] = "e8ae75f7-d931-4300-974c-8fa5a69142d5";
//остальные настройки получаем автоматически
$config['url'] = 'http://' . $_SERVER['HTTP_HOST'];
$config['key'] = "some very-very long string without any non-latin characters due to different string representations inside of variable programming languages";

$vopros = "Добрый день!";
$whattosend = '["' . $session . '","' . urldecode($vopros) . '"]';
$hashed = XORFUNC::XOR_encrypt(base64_encode($whattosend), $config['key']);
$myCurl = curl_init();
curl_setopt_array($myCurl, array(
 CURLOPT_URL => 'http://iii.ru/api/2.0/json/Chat.request',
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_POST => true,
 CURLOPT_POSTFIELDS => $hashed,
));
$response = curl_exec($myCurl);
curl_close($myCurl);

//получаем ответ от бота на вопрос
$answer = json_decode(base64_decode(XORFUNC::XOR_decrypt($response, $config['key'])));
$otvet = $answer->result->text->value;
echo $otvet;
