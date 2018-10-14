<?php
$host = 'codefundo.mysql.database.azure.com';
$username = 'codefundo@codefundo';
$password = 'Microsoft123';
$db_name = 'users';
extract($_GET);
$point = explode('_', $locations);
$lat =  $point[0];
echo $lat
$lng = $point[1];
//Establishes the connection
$conn = mysqli_init();
mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
if (mysqli_connect_errno($conn)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

//Run the Delete statement
if ($stmt = mysqli_prepare($conn, "DELETE FROM Maps WHERE Lat = ? )) {
mysqli_stmt_bind_param($stmt, 's', $lat);
mysqli_stmt_execute($stmt);
printf("Delete: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

//Close the connection
mysqli_close($conn);
?>
