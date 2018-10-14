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
$name=$point[0];
$lat =  $point[1];
$lng = $point[2];
//Create an Insert prepared statement and run it


if ($stmt = mysqli_prepare($conn, "INSERT INTO Maps (Name,Lat,Lon) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $name, $lat, $lng);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>