
<html>
  <head>
    <title>Don't Go Zones</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        top:50px;
        left:50px;
        height: 80%;
        width:80%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <h2> These points are the Danger zones</h2>
  <body>
    <div id="map"></div>
    <script>

         var currentId = 0;
    var uniqueId = function() {
      return ++currentId;
        }
        
        var markers = {};
        var id ;
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 13.1769, lng: 77.1237 }
        });
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
