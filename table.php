<?php
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

// Run the create table query
if (mysqli_query($conn, '
CREATE TABLE Maps (
`Id` INT NOT NULL AUTO_INCREMENT ,
`Name` VARCHAR(200) NOT NULL ,
`Lat` DOUBLE NOT NULL ,
`Lon` DOUBLE NOT NULL ,
PRIMARY KEY (`Id`)
);
'))
  
echo "hello";

//Close the connection
mysqli_close($conn);
?>
