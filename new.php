
<html>
  <head>
    <title>Don't Go Zones</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
 
      #map {
         position: fixed;
        top:60px;
        left:50px;
        height: 90%;
        width:60%;
      }
      #text{
         position: fixed;
        left:1000px;
        top:210px;
      }
      #help{
         position: fixed;
        left:1000px;
        top:240px;
      }
      #he{
        position: fixed;
        left:500px;
      }
      #ac{
         position: fixed;
        left:1000px;
        top:150px;
      }
      #del{
         position: fixed;
        left:1000px;
        top:180px;
      }
       div.a {
    text-align: center;
     position: fixed;

} 

      div.c {
         position: fixed;
  
} 
 


      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      
      * {
   font-family: myFirstFont;
}
    </style>
  </head>
  <div id="he" >
  <h2 > These points are the Danger zones</h2>
</div>
  <body background="fl.jpg">
    <div class="c" id="ac"><font face="verdana" size="4" color=#FFFFFF><b><li>The zones that are marked are not accessible</li></b></font></div>
    
    <div class="c" id="del"><font face="verdana" size="4" color=#FFFFFF ><b><li>The zones can be deleted with a right click</li></b></font></div>
    <div class="c" id="text"><font face="verdana" size ="4" color=#FFFFFF><b><li>MARK the zones that you know are not accessible</li></b></font></div>
    <div class ="c"id="help"><font face="verdana" size="4" color=#FFFFFF><b><li>HELP other people</li></b></font></div>
    <div id="map"></div>
    <script>

         var currentId = 0;
    var uniqueId = function() {
      return ++currentId;
        }
        
        var markers = {};
        var id ;
      function initMap() {
        var infoWindow;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom:9,
          center: {lat: 13.1769, lng: 77.1237 }
        });
         infoWindow = new google.maps.InfoWindow;
          if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  }
  else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}
         xhr=new XMLHttpRequest();
        fetchDetails()
        function fetchDetails()
        {
          xhr.onreadystatechange=function()
          {
            if(xhr.readyState==4 && xhr.status==200)
            {
              var res=xhr.responseText;
              json=JSON.parse(res);
              for( var o in json ){

                lat = json[ o ].lat;
                lng=json[ o ].lng;
                name=json[ o ].name;
                var markerId = getMarkerUniqueId(lat,lng);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat,lng),
                    name:name,
                    map: map,
                    id: 'marker_' + markerId
                }); 
                 markers[markerId] = marker;
   
      bindMarkerEvents(marker); 
            }
     
             
            }
        }                   
        xhr.open("GET",'fetch.php',true);
        xhr.send();    
        }
       
        map.addListener('click', function(e) {
          placeMarkerAndPanTo(e.latLng, map);
          getName(map,e.latLng);
        });
       
      }








   
      function placeMarkerAndPanTo(latLng, map) {
        
        var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
        var markerId = getMarkerUniqueId(latLng.lat(), latLng.lng());
        var marker = new google.maps.Marker({
          
          position: latLng,
          map: map,
          icon: image,
          id: 'marker_' + markerId
        });
        map.panTo(latLng);
        markers[markerId] = marker;
       
        bindMarkerEvents(marker); 
       // cache created marker to markers object with id as its key
        
        
      }

function getName(map,point){

        xhr=new XMLHttpRequest();
        getDetails(map,point.lat(),point.lng())
        function getDetails(map,lat,lng)
        {
          xhr.onreadystatechange=function()
          {
            if(xhr.readyState==4 && xhr.status==200)
            {
              
             console.log("Done");
            }
        }                   
        xhr.open("GET",'insert.php?locations='+lat+','+lng,true);
        xhr.send();    
        }
    }   



      var getMarkerUniqueId= function(lat, lng) {
    return lat + '_' + lng;
}
      var bindMarkerEvents = function(marker) {
    google.maps.event.addListener(marker, "rightclick", function (point) {
        var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
        var marker = markers[markerId]; // find marker
        removeMarker(marker, markerId); // remove it
    });
};
/**
 * Removes given marker from map.
 * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
 * @param {!string} markerId Id of marker.
 */ 
var removeMarker = function(marker, markerId) {
    marker.setMap(null); // set markers setMap to null to remove it from map
    delete markers[markerId];
     // delete marker instance from markers object
    console.log(markerId);
    mark=markerId.split('_');
    xhr=new XMLHttpRequest();
        delDetails(mark[0],mark[1])
        function delDetails(lat,lng)
        {
          xhr.onreadystatechange=function()
          {
            if(xhr.readyState==4 && xhr.status==200)
            {
              
             console.log("Done Deleting");
            }
        }                   
        xhr.open("GET",'delete.php?locations='+parseFloat(mark[0])+','+parseFloat(mark[1]),true);
        xhr.send();    
        }


};
      
      
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqoHgGnauEs3MfqM-42Xd9EZRrl73X2k4&callback=initMap">
    </script>
  </body>
</html>
