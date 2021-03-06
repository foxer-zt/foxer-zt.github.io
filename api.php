<?php
header('Access-Control-Allow-Origin: *');  
$allowedRequests = ['moosh' => 'processMooshRequest', 'combined' => 'combineMoosh'];
$intersection = array_intersect_key($allowedRequests, $_GET);
if (count($intersection) === 0) {
    die("No route specified");
} else {
    foreach ($intersection as $route => $handler) {
        if (function_exists($handler)) {
            echo call_user_func($handler, $_GET[$route]);
        }
    }
}

function mergeByName($newData)
{
    //$newData = [['name' => 'irishdash', 'videos' => [11111]]];
    $existedData = json_decode(file_get_contents('https://irishdash.herokuapp.com/api.php?moosh=all'), true);
    $namesToUpdate = [];
    foreach ($newData as $item) {
        $namesToUpdate[strtolower($item['name'])] = count($namesToUpdate[$item['name']]) 
            ? array_merge($namesToUpdate[$item['name']], $item['videos'])
            : $item['videos'];
    }
    foreach ($existedData as &$item) {
        if (in_array($item['name'], array_keys($namesToUpdate))) {
            $item['videos'] = array_merge($item['videos'], $namesToUpdate[$item['name']]);
            unset($namesToUpdate[$item['name']]);
        }
    }

    foreach ($namesToUpdate as $name => $videos) {
        $existedData[] = ['name' => $name, 'videos' => $videos];
    }

    return $existedData;

}

function combineMoosh($requestValue)
{
    $content = array_filter(explode("\n", file_get_contents('http://irishdash-logger.herokuapp.com/?method=getLog&logFile=videos')));
    $data = [];
    foreach ($content as $line) {
        list($name, $videoId) = explode('#%--%#', $line);
        $data[] = ['name' => strtolower(trim($name)), 'videos' => [trim($videoId)]];
    }
    
    return json_encode(mergeByName($data));
}

function processMooshRequest($name)
{
    $data = json_decode(file_get_contents('moosh.json'),true);
    $returnedData = [];
    switch ($name) {
        case 'all':
            $returnedData = $data;
            break;
        default:
            foreach ($data as $moosh) {
                if ($moosh['name'] == $name) {
                    $returnedData = $moosh;
                    break;
                }
            }
            break;
    }
    return json_encode($returnedData);
}
