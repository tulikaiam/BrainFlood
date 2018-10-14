<?php
header("Access-Control-Allow-Origin:*");



$host = 'codefundo.mysql.database.azure.com';
$username = 'codefundo@codefundo';
$password = 'Microsoft123';
$db_name = 'users';

//Establishes the connection
$conn = mysqli_init();
mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
if (mysqli_connect_errno($conn)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

extract($_GET);
//echo $locations;
$point = explode(',', $locations);
$lat =  $point[0];
$lng = $point[1];
//Create an Insert prepared statement and run it

$res = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyAqoHgGnauEs3MfqM-42Xd9EZRrl73X2k4&callback=initMap'),true);

$name = $res['results'][1]['formatted_address'];

if ($stmt = mysqli_prepare($conn, "INSERT INTO Maps (Name,Lat,Lon) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $name, $lat, $lng);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>