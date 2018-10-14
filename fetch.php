<?php

header("Access-Control-Allow-Origin:*");
$host = 'codefundo.mysql.database.azure.com';
$username = 'codefundo@codefundo';
$password = 'Microsoft123';
$db_name = 'users';

$conn = mysqli_init();
mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
$data = mysqli_query($conn, "SELECT * FROM Maps");
    foreach ($data as $key)
    {
                $locations[]=array( 'name'=>$key['Name'], 'lat'=>$key['Lat'], 'lng'=>$key['Lon'] );
    }
    /* Convert data to json */
    $markers = json_encode( $locations );
    ?>
