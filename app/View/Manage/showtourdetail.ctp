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
        //経由地設定
        var waypts = [];
            <?php
                for ($i = 0; $i < $num_of_waypoints ; $i++){
                    echo "  waypts.push({\n";
                    echo "      location: '$waypoints[$i]',\n";
                    echo "      stopover:true\n";
                    echo "  });\n";
                }
            ?>

        //経由地通過ルートの最適化判定
        var routeOptimized = true;
        <?php if($tour_route_optimized == 0){ ?>
            routeOptimized = false;
        <?php }; ?>

        //地図リクエスト用オブジェクト生成
        var request = {
            origin: '<?php echo $start_lat . "," . $start_lng ?>',
            //origin: '元町・中華街',
            destination: '<?php echo $end_lat . "," . $end_lng ?>',
            waypoints: waypts,
            unitSystem: google.maps.DirectionsUnitSystem.METRIC,
            optimizeWaypoints: routeOptimized,
            avoidTolls:true,
            travelMode: google.maps.TravelMode.WALKING
        };

        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }else{
                sweetAlert('request failed: ' + status);
            }
        });

        /*
        //経由地の設定が、８個が上限であることへの対策
        //リクエストを複数回実施して、結果を結合して描画する（2015/8/30：未完成）
        var org_start = '<?php echo $start_lat . "," . $start_lng ?>';
        var org_end = '<?php echo $end_lat . "," . $end_lng ?>';
        var unit = 10;
        var result;
        var push = Array.prototype.push;
        var next_waypts;
        for(var wp = 0; wp <= waypts.length;){
            var next_start = org_start;
            var next_end = org_end;
            var next_start_wp = 0;
            var next_end_wp = waypts.length - 1;

            //二回目以降のループでのスタート地点設定
            if(wp > 0){
                next_start = waypts[wp].location;
                next_start_wp = wp + 1;
            }

            //最終目的地が次のゴール地点ではない場合のゴール地点設定
            if(wp + unit < waypts.length){
                next_end = waypts[wp+unit-1].location;
                next_end_wp = wp + unit - 2
            }

            //最終目的地が次のゴール地点ではない場合の経由地設定
            if(next_start_wp != 0 || next_end_wp != 0){
                next_waypts = waypts.slice(next_start_wp, next_end_wp);
            }else{
                next_waypts = waypts;
            }

            //地図リクエスト用オブジェクト生成
            var request = {
                //origin: next_start,
                origin: '元町・中華街',
                destination: next_end,
                waypoints: next_waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.WALKING
            };

            //リクエスト
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    if(!result){
                        //最初のリクエストの場合には、ルートを持つオブジェクトを保持
                        result = response;
                    }else{
                        //二回目以降のリクエストの場合には、ルートを追加
                        /*
                        result.routes[0].legs = push.apply(result.routes[0].legs, response.routes[0].legs);
                        result.routes[0].overview_path = push.apply(result.routes[0].overview_path, response.routes[0].overview_path);
                        result.routes[0].bounds = result.routes[0].bounds.extend(response.routes[0].bounds.getNorthEast());
                        result.routes[0].bounds = result.routes[0].bounds.extend(response.routes[0].bounds.getSouthWest());
                        */
                /*    }

                    //最後のリクエストの場合には、描画
                    if(wp + unit >= waypts.length){
                        directionsDisplay.setDirections(result);
                    }
                }else{
                    sweetAlert('request failed: ' + status);
                }
            });
            //wp = wp + unit;
            wp = waypts.length;
        };
        */
    }


    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).ready(function () {
        setTimeout(function(){calcRoute()},500);
    });

    $(window).on('load', function(){
        var w = $(window).width() * 0.9;
        $('div#map-canvas').attr('width', w);
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
        <a class="btn btn-info btn-lg" href="/manage/showtour" style="width:100%;" id="add-button">ツアー一覧へ戻る</a>
        <a class="btn btn-info btn-lg" href="/manage/" style="width:100%;" id="add-button">管理画面トップへ戻る</a>
    </div>

</div>
