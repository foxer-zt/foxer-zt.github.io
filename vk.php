<?php 

if (!isset($_REQUEST)) { 
  return; 
} 
$confirmation_token = $_ENV['confirmation_token']; 
$token = $_ENV['token']; 
$data = json_decode(file_get_contents('php://input'));
$commands = [
  '!cat' => 'cat',
  '!youtube' => 'youtube',
  '!mouse' => 'mouse',
  '!mooshTube' => 'mooshTube',
];
switch ($data->type) { 
  case 'confirmation': 
    echo $confirmation_token; 
    break; 

  case 'message_new': 
    $userId = $data->object->user_id; 
    $userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0")); 
    $userName = $userInfo->response[0]->first_name;
    $lastName = $userInfo->response[0]->last_name;
    $text = $data->object->body;
    $message = "Привет, $userName!\n Да прибудет с тобой сила!\nСписок доступных комманд:\n" . implode(', ', array_keys($commands));
    foreach($commands as $command => $function) {
      if (strpos($data->object->body, $command) !== false && function_exists($function)) {
        $message = $function($text);
      }
    }
    $request_params = array( 
      'message' => $message,
      'user_id' => $userId, 
      'access_token' => $token, 
      'v' => '5.62' 
    ); 

  $get_params = http_build_query($request_params); 
  file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
  echo('ok'); 
  break; 
}

function mooshTube($text)
{
    preg_match('@!mooshTube\s(.*?)\s(.*)$@', $text, $matches);
    $matches = array_filter($matches);
    if (!isset($matches[1] || !isset($matches[2])) {
      return "Использование: !mooshTube ваш_никнейм код_видео_на_ютубе\nНапример !mooshTube Irishdash H9HofYb_-kY";
    }

    $data = [
        'method' => 'log',
        'message' => "{$splittedCommand[1]}#%--%#{$matches[2]}",
        'logFile' => 'videos',
        'withoutDate' => true,
    ];
    file_get_contents('http://irishdash-logger.herokuapp.com/?' . http_build_query($data));
    return "Видео {$splittedCommand[3]} для пользователя {$splittedCommand[2]} добавленно.";
}

function youtube($text) 
{
    preg_match('@!youtube\s(.*)@', $text, $matches);
    $matches = array_filter($matches);
    if (!isset($matches[1]) ) {
      return "Введите запрос. Например: !youtube котики";
    }
  
    $youtubeManager = 'https://irishdash.herokuapp.com/youtube.php?q=' . urlencode($matches[1]);
    $videoIds = json_decode(file_get_contents($youtubeManager), true);
    $randomId = array_rand($videoIds);
    return count($videoIds) 
      ? "По вашему запросу '{$matches[1]}' мы нашли:\nhttps://www.youtube.com/watch?v=" . $videoIds[$randomId]
      : "По вашему запросу '{$matches[1]}' мы ничего ненашли :(";
}

function cat($text)
{
    $catApiUrl = 'http://thecatapi.com/api/images/get?format=xml&api_key=MTUwMjE2';
    $xml = simplexml_load_string(file_get_contents($catApiUrl), "SimpleXMLElement", LIBXML_NOCDATA);
    $response = json_decode(json_encode($xml), true);
    return "Держи котика, няша :3\n" . $response['data']['images']['image']['url'];
}

function mouse($text)
{
  preg_match('@!mouse\s(.*)@', $text, $matches);
    $matches = array_filter($matches);
    if (!isset($matches[1]) ) {
      return "Введите запрос. Например: !mouse Irishdash";
    } else {
      $mapping = [
        'name' => 'Имя',
        'tribe' => 'Племя',
        'title' => 'Титул',
        'rounds' => 'Количество сыграных раундов',
        'cheese' => 'Собрано сыра',
        'sham_cheese' => 'Собрано сыра за шамана',
        'saves' => 'Спасено мышей',
        'hard_saves' => 'Спасено мышей в hard mode',
        'first' => 'Количество собраных фестов',
        'bootcamps' => 'Количество пройденных буткампов',
        'cratio' => '% собранного сыра',
        'sratio' => '% спасённых мышей',
        'fratio' => '% фестов',
        'rank' => 'Ранг',
      ];
      $mouseApi = 'http://api.formice.com/mouse/stats.json?n=' . $matches[1];
      $mouseStats = json_decode(file_get_contents($mouseApi), true);
      $translatedData = [];
      foreach ($mouseStats as $field => $value) {
        if (isset($mapping[$field])) {
          $translatedData[] = "{$mapping[$field]}: $value";
        }
      }
      return count($translatedData) 
        ? "По вашему запросу '{$matches[1]}' мы нашли:\n" . implode("\n", $translatedData)
        : "По вашему запросу '{$matches[1]}' мы ничего ненашли :(";
    }
}
