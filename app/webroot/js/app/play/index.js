var app = app || {};
app.params = app.params || {};

(function(){

    /**
    * 画面表示時の処理
    */ 
    $(function(){
        // Play画面初回表示時
        if ($.urlParam('direction_id') == null) {
            // Play続行するか確認する
            confirmToContinue();
        }

        // 画像のスライダーを有効化
        $('.flexslider').flexslider();

        
        //現在地の定期取得
        setInterval(function(){
            exec(app.params.end_location.lat, app.params.end_location.lng);
        }, 2000);

        /**
        * イベント定義
        */
        // タブ切り替え時
        var hasShownTab2 = false; // tab2が表示されたかどうか
        var hasShownTab3 = false; // tab3が表示されたかどうか
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var activated_tab = e.target; // active tab
            var tabName = $(activated_tab).attr('href');

            // tab2の初回表示判定
            if (tabName == '#tab2' && hasShownTab2 == false) {
                hasShownTab2 = true;
                //方向のイメージを表示
                getDirectionImg();

                // 減点処理
                updateDirectionsScore(5, app.params.direction_id);
            }

            // tab3の初回表示判定
            if (tabName == '#tab3' && hasShownTab3 == false) {
               hasShownTab3 = true;
               //地図表示
               initialize();
               setTimeout(function(){calcRoute()},1000);

               // 減点処理
               updateDirectionsScore(10, app.params.direction_id);
            }
        });
    });

    /**
    * イベント定義
    */
    
    /**
    * 以下、関数定義
    */

    // プレイ継続するかどうか確認をとる
    function confirmToContinue () {
       var warningText = '' + app.params.total_distance + 'm ( 約' + Math.floor(app.params.total_duration / 60) + '分 ) のコースです。\n\nプレイを続けますか?';

        swal({
                title: "",
                text: warningText,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Start",
                closeOnConfirm: true
            }, function(res){
              if (res) {
                 // show instruction
                 $("#instruction").modal('show');
              } else {
                // go back
                history.back();
              }
            });
    }

    function getDirectionImg(){
        from = new google.maps.LatLng(app.params.start_location.lat, app.params.start_location.lng);
        to = new google.maps.LatLng(app.params.end_location.lat, app.params.end_location.lng);
        heading = google.maps.geometry.spherical.computeHeading(from, to);
        img = "http://maps.googleapis.com/maps/api/streetview?size=640x300&location=" + app.params.start_location.lat + ',' + app.params.start_location.lng + "8&fov=120&pitch=0&heading="+heading+"&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y";
        document.getElementById("direction").src = img;
    }
    
    var nearFlag = false;
    var lat = 0;
    var lng = 0;

    //-----地図表示処理-----
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var center = new google.maps.LatLng(app.params.start_location.lat, app.params.start_location.lng);
        var mapOptions = {
            zoom: 12,
            center: center
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        directionsDisplay.setMap(map);
    }

    function calcRoute() {
        var start = app.params.start_location.lat + ',' + app.params.start_location.lng;
        var end = app.params.end_location.lat + ',' + app.params.end_location.lng;
      
        var request = {
            origin: start,
            destination: end,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.WALKING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                
                $('#map-canvas').appendTo('#tab3');
            }
        });
    }
    //-----地図表示処理-----
    
    
    //スポット到着判定
    function isGoal(message){
        from = new google.maps.LatLng(lat,lng);
        to = new google.maps.LatLng(app.params.end_location.lat, app.params.end_location.lng);
        distance = google.maps.geometry.spherical.computeDistanceBetween(from, to);
        return true;
        if(distance <= 1000){
            return true;
        }else{
            say('まだゴールじゃないげん！');
            updateDirectionsScore(3, app.params.direction_id);
            return false;
        }
    }

    function say(message) {
        document.getElementById('distance-message').innerText = message
    }

    function exec(to_lat,to_lng){
    if (navigator.geolocation) {
        // 位置情報を取得する
        navigator.geolocation.getCurrentPosition(
                // 位置情報取得成功時
                function (pos) {
                lat = pos.coords.latitude;
                lng = pos.coords.longitude;
                },
                // 位置情報取得失敗時
                // 兼六園の座標を設定
                function (pos){
                lat = 36.562127;
                lng = 136.662458;
                //alert("GPSをOnにしてください");
                });
    } else {
        lat = 36.562127;
        lng = 136.662458;
        //alert("GPSをOnにしてください");
    }

    if(lat != 0 || lng != 0){
        from = new google.maps.LatLng(lat,lng);
        to = new google.maps.LatLng(to_lat,to_lng);

        distance = google.maps.geometry.spherical.computeDistanceBetween(from, to);

        var message = "写真のスポットまで「" + distance.toFixed(1) + "」m ";

        $msg = $('#distance-message');
        if(distance > 100){
            nearFlag = false;
            changeClass($msg, 'alert-danger');
        }else if(50 < distance  && distance <= 100){
            nearFlag = false;
            vibrator.slow();
            changeClass($msg, 'alert-warning');
        }else if(30 < distance  && distance <= 50){
            nearFlag = false;
            vibrator.middle();
            changeClass($msg, 'alert-info');
        }else if(distance <= 10){
            nearFlag = true;
            vibrator.fast();
            changeClass($msg, 'alert-success');
        }
        say(message);
    }
    }

    // alertのクラスを切り返る
    function changeClass($elem, className) {
      var classes = ['alert-danger', 'alert-warning', 'alert-success', 'alert-info']; 
      $(classes).each(function(value){
        $elem.removeClass(value);
      });
      $elem.addClass(className);
    } 

    // スコア減点処理
    function updateDirectionsScore(value,direction_id){
        $.ajax({
        type: "POST",
        url: "/play/update",
        data: 'direction_id=' + direction_id + '&value='+ value,
        success: function() {
        },
        error: function() {
            alert('error');
        }
        });
        return true;
    }

    // URLのGETパラメータを取得するUtilメソッド
    $.urlParam = function(name){
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) 
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == name) 
            {
                return sParameterName[1];
            }
        }
    }

})();

