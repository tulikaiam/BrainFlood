<?php
	header("Access-Control-Allow-Origin:*");
	extract($_GET);
	//echo $locations;
	$point = explode(',', $locations);
	$lat =  $point[0];
	$lng = $point[1];
	
	$pi =3.14;
    $earth = 6378.137;
    $m = (1 / ((2 * $pi / 360) * $earth)) ;

    $latitude=$lat;
    $longitude=$lng;
       
    $lat_array=[];
    $lng_array=[];
    $n= (1 / ((2 * $pi / 360) * $earth)); 
        
    for($i=0;$i<5;$i++){
          $new_latitude = $latitude + ($i * $m)/1000;
          $new_longitude = $longitude + ($i * $n) / cos($new_latitude * ($pi / 180));
          //console.log(new_latitude,new_longitude)
          array_push($lat_array,$new_latitude);
          array_push($lng_array,$new_longitude);
          
          $new_latitude = $latitude + ($i * $m)/1000;
          $new_longitude = $longitude - ($i * $n) / cos($new_latitude * ($pi / 180));
          //console.log(new_latitude,new_longitude)
          array_push($lat_array,$new_latitude);
          array_push($lng_array,$new_longitude);

          $new_latitude = $latitude - ($i * $m)/1000;
          $new_longitude = $longitude + ($i * $n) / cos($new_latitude * ($pi / 180));
          //console.log(new_latitude,new_longitude)
          array_push($lat_array,$new_latitude);
          array_push($lng_array,$new_longitude);

          $new_latitude = $latitude - ($i * $m)/1000;
          $new_longitude = $longitude - ($i * $n) / cos($new_latitude * ($pi / 180));
          //console.log(new_latitude,new_longitude)
          array_push($lat_array,$new_latitude);
          array_push($lng_array,$new_longitude);
          }

    $elevation=0;
    $max_elevation=-1;
    $latitude=0;
    $longitude=0;
	//$res = file_get_contents('https://maps.googleapis.com/maps/api/elevation/json?locations='.$lat.','.$lng.'&key=AIzaSyAqoHgGnauEs3MfqM-42Xd9EZRrl73X2k4');
	for($i=0;$i<count($lat_array);$i++)
	{
		
		$res = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/elevation/json?locations='.$lat_array[$i].','.$lng_array[$i].'&key=AIzaSyAqoHgGnauEs3MfqM-42Xd9EZRrl73X2k4&callback=initMap'),true);
		
		$elevation = $res['results'][0]['elevation'];

		if($max_elevation<$elevation)
		{
			$max_elevation=$elevation;
			$latitude=$res['results'][0]['location']['lat'];
			$longitude=$res['results'][0]['location']['lng'];
		}
		
	}
	$array=[];
	array_push($array,$max_elevation,$latitude,$longitude);

	echo json_encode($array);

?>
