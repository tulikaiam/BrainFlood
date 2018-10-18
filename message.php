<?php
header("Access-Control-Allow-Origin:*");
extract($_GET);
//echo $locations;
$point = explode(',', $data);
$msg =  $point[0];
$no = $point[1];
//Create an Insert prepared statement and run it
$res = json_decode(file_get_contents('https://smsapi.engineeringtgr.com/send/?Mobile=9663126670&Password=tulika&Message='.$msg.'&To='.$no.'&Key=tulikPEUuMjSBrXdnTGbW81eK'),true);

echo $res;