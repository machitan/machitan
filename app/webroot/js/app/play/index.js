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
        // ダイアログ表示時
        $('a[data-target=#next-direction]').click(function(){
            this.modal();
        });
        $('a[data-target=#next-spot-map]').click(function(){
            this.modal();
        });

        var hasShownNextDirectionDialog = false; // 次の方向ダイアログが表示されたかどうか
        var hasShownNextSpotMapDialog = false; // 次のスポットまでの地図ダイアログが表示されたかどうか
        $('#next-direction').on('show.bs.modal', function (e) {
            // 初回表示判定
            if (hasShownNextDirectionDialog == false) {
                hasShownNextDirectionDialog = true;
                //方向のイメージを表示
                getDirectionImg();

                // 減点処理
                updateDirectionsScore(5, app.params.direction_id);
            }
          });
        $('#next-spot-map').on('show.bs.modal', function (e) {
            // 初回表示判定
            if (hasShownNextSpotMapDialog == false) {
               hasShownNextSpotMapDialog = true;
               //地図表示
               setTimeout(function(){initialize()},500);
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
       var warningText = '' + app.params.total_distance + 'm ( 約' + Math.floor(app.params.total_duration / 60) + '分 ) のコースです。<br/><br/>プレイを続けますか?';

        swal({
                title: "",
                html: warningText,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Start",
                closeOnConfirm: true
            }, function(res){
              if (res) {
                 // show introduction
                 introJs().start();
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
        img = "http://maps.googleapis.com/maps/api/streetview?size=640x300&location=" + app.params.start_location.lat + ',' + app.params.start_location.lng + "8&fov=120&pitch=0&heading="+heading+"&sensor=false&key=AIzaSyAxGdNmlCsgZAPqhWTBE1gP0_R9yFC5iIs";
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
               $('#map-canvas').appendTo('#next-spot-map div.modal-body');
            }
        });
    }
    //-----地図表示処理-----
    
    
    //スポット到着判定
    function isGoal(){
        from = new google.maps.LatLng(lat,lng);
        to = new google.maps.LatLng(app.params.end_location.lat, app.params.end_location.lng);
        distance = google.maps.geometry.spherical.computeDistanceBetween(from, to);
        // 15m以内ならゴールとする
        return (distance < 15) ? true : false;
    }


    var hasGeo = false; // GPS情報を取得済みかどうか

    function exec(to_lat, to_lng){
        if (navigator.geolocation) {
             // 位置情報を取得する
             navigator.geolocation.getCurrentPosition(
                // 位置情報取得成功時
                function (pos) {
                  lat = pos.coords.latitude;
                  lng = pos.coords.longitude;
                  updatePosition(to_lat, to_lng);
                },
                // 位置情報取得失敗時
                function (pos){
                  alert("GPSをOnにしてください");
                });
        } else {
            alert("GPSをOnにしてください");
        }
    }

    function updatePosition(to_lat, to_lng) {
        if (isGoal()) {
            // 現在地がゴールの場合
            swal({
                title: "写真のスポットに到着しました！",
                text: "",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "次のスポットへ",
                customClass: "swal-play",
                allowOutsideClick: true
            }, function(res){
              if (res) {
                // 次のスポットへ
                $("#arrival").submit();
              } else {
                // do nothing
              }
            });
        }

        from = new google.maps.LatLng(lat,lng);
        to = new google.maps.LatLng(to_lat,to_lng);
        distance = google.maps.geometry.spherical.computeDistanceBetween(from, to);

        var message = distance.toFixed(1) + "m";

        $msg = $('#distance-message');
        if(distance > 100){
            nearFlag = false;
        }else if(50 < distance  && distance <= 100){
            nearFlag = false;
            vibrator.slow();
        }else if(30 < distance  && distance <= 50){
            nearFlag = false;
            vibrator.middle();
        }else if(distance <= 10){
            nearFlag = true;
            vibrator.fast();
        }
        $('#distance-message span').text(message);

        if (hasGeo == false) {
            $("#distance-message div").show();
            $("#distance-message i").hide();
            hasGeo = true;
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

var defaultOrientation; // window.orientationが0または180の時に縦長であればtrue

// 初期化処理
window.addEventListener('load', function() {
  if('orientation' in window) {
    var o1 = (window.innerWidth < window.innerHeight);
    var o2 = (window.orientation % 180 == 0);
    defaultOrientation = (o1 && o2) || !(o1 || o2);
    checkOrientation();
  }
  // もしあれば、その他Webアプリの初期化処理
}, false);

// iOSの場合とそれ以外とで画面回転時を判定するイベントを切り替える
var event = navigator.userAgent.match(/(iPhone|iPod|iPad)/) ? 'orientationchange' : 'resize';

// 画面回転時に向きをチェック
window.addEventListener(event, checkOrientation, false);
function checkOrientation () {
  if('orientation' in window) {
    // defaultOrientationがtrueの場合、window.orientationが0か180の時は縦長
    // defaultOrientationがfalseの場合、window.orientationが-90か90の時は縦長
    var o = (window.orientation % 180 == 0);
    if((o && defaultOrientation) || !(o || defaultOrientation)) {
      // 縦長
      $('div.info').show();
    }
    else {
      // 横長
      $('div.info').hide();
    }
  }
};

})();

