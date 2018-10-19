<?php
header("Access-Control-Allow-Origin:*");
extract($_GET);
//echo $locations;
$point = explode('_', $data);
$msg =  $point[0];
$no = $point[1];
//Create an Insert prepared statement and run it
$res = json_decode(file_get_contents('http://api.msg91.com/api/sendhttp.php?country=91&sender=MSGIND&route=4&mobiles='.$no.'&authkey=243560AIvvhnmj0C5bc9e6ba&message='.$msg),true);

echo $res;
