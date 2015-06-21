<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript">
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var center = new google.maps.LatLng(<?php echo $start_lat ?>,<?php echo $start_lng?>);
  var mapOptions = {
    zoom: 9,
    center: center
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = '<?php echo $start_lat . "," . $start_lng ?>';
  var end = '<?php echo $end_lat . "," . $end_lng ?>';
  var waypts = [];
      <?php
      for ($i = 0; $i < $num_of_waypoints ; $i++){
      echo "waypts.push({";
      echo "      location: '$waypoints[$i]',";
      echo "      stopover:true";
      echo "});";
      }
      ?>
      
  var request = {
      origin: start,
      destination: end,
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      /*
        var route = response.routes[0];
      var summaryPanel = document.getElementById('directions_panel');
      summaryPanel.innerHTML = '';
      // For each route, display summary information.
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
        summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
      }*/
    }
  });
 }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).ready(function () {
        setTimeout(function(){calcRoute()},500);
    });
    
    $(window).on('load', function(){
        var w = $(window).width() * 0.9;
        $('div#map-canvas').attr('width', w);
        sweetAlert("ツアー登録が完了しました！", "登録したツアーの内容を確認して下さい", "success");
    });
    
</script>

<div class="container">

    <div class="panel panel-info">
        <div class="panel-heading"><i class="mdi-maps-place"></i>　ツアー名</div>
        <div class="panel-body">
            <h3><?php echo $tour_name?></h3>
        </div>
    </div>
    
    <div class="panel panel-info">
        <div class="panel-heading"><i class="mdi-maps-place"></i>　ツアー説明</div>
        <div class="panel-body">
            <h4><?php echo $tour_description?></h4>
        </div>
    </div>
    
    <div class="panel panel-info">
        <div class="panel-heading"><i class="mdi-maps-place"></i>　登録したツアーのルート例</div>
        <div class="panel-body">
            <p>このルートは一例となります。ユーザーがツアーを始める位置によってルートは若干異なる可能性があります。</p>
            <div id="map-canvas" style="height:400px"></div>
            </div>
    </div>
    
    <div style="text-align:center;">
        <a class="btn btn-info btn-lg" href="/manage/" style="width:100%;" id="add-button">管理画面トップへ戻る</a>
    </div>
    
</div>