<?php
class ModIiiRu
{
    const IiiID = 'a3c32fd5-e666-48a7-97fc-eb4630629760';
    public function cmd($cmd)
    {
	      global $cook;
        $data = json_encode(array($cook, $cmd));
        $data = self::sendMessage(self::xorKey($data, false));
        $data = json_decode($data);
        $text = $data->result->text->value;
        return $text;
        //$this->say($text);
    }
 private static function sendMessage($send){
        $url='http://iii.ru/api/2.0/json/Chat.request';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send);
        $res = curl_exec($ch);
        if (!$res)
            return false;
        curl_close($ch);
        return self::xorKey($res, true);
    }
    static function xorKey($res, $decode)
    {
        $key = "some very-very long string without any non-latin characters due to different string representations inside of variable programming languages";
        $keylen = strlen($key);
        $res = $decode ? base64_decode($res) : base64_encode($res);
        $strlen = strlen($res);
        $i = 0;
        $result = '';
        while ($i<$strlen)
        {
            $buf = $res[$i] ^ $key[$i % $keylen];
            $result .= $buf;
            $i++;
        }
        return $decode ? base64_decode($result) : base64_encode($result);
    }
}
$mod = new ModIiiRu();
echo $mod->cmd($_GET['text']);
