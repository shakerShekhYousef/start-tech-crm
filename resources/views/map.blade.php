<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Map locations</title>
</head>

<body>
    <div id="map" style="height: 90vh; width: 100%;"></div>
    <div style="background:#ccc;width:50%;margin:auto;">
        <p style="float:left;color:#2c2d7c;">Empty Map Location: <b> {{ $emptyMarker->count() }} </b></p>
        <a style="float:right;background:#2c2d7c;color:#fff;padding:.5rem 2rem;border-radius:10px;margin-top:8px;text-decoration:none;"
            href="{{ url('/dashboard') }}">Back To Dashboard</a>
    </div>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJdzfNK0VG9o40xK6P-haaVh3ognsx0fw&v=3.exp&callback=initMap"
        async defer></script>
  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

    <script>
      locations = []
    </script>
    @foreach ($markers as $index => $event)
      <script>
        locations.push({
          lat: parseFloat("{{ trim($event->lat) }}"),
          lng: parseFloat("{{ trim($event->lng) }}")
        })
      </script>
    @endforeach
    
    <script>
        function initMap() {

            //The center location of our map.
            var centerOfMap = new google.maps.LatLng(25.19777891746296, 55.278176647123736);
            //Map options.
            var options = {
                center: centerOfMap, //Set center.
                zoom: 7 //The zoom value.
            };

            //Create the map object.
            map = new google.maps.Map(document.getElementById('map'), options);

            const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const markers = locations.map((location, i) => {
              return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length]
              });
            });
          

            new MarkerClusterer(map, markers, {
              imagePath:
                "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
            });

        }

    </script>

</body>

</html>
