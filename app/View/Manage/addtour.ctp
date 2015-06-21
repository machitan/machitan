<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0" />
<script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript" charset="UTF-8"></script>

<script>
    var lat = 36.562127;
    var lng = 136.662458;

    function exec() {
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
                function (pos) {
                    lat = 36.562127;
                    lng = 136.662458;
                    //alert("GPSをOnにしてください");
                });
        } else {
            lat = 36.562127;
            lng = 136.662458;
            //alert("GPSをOnにしてください");
        }
    }
    
    var map;
    var marker;

    function init() {

        // Google Mapで利用する初期設定用の変数
        var latlng = new google.maps.LatLng(lat, lng);
        var opts = {
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: latlng
        };

        // getElementById("map")の"map"は、body内の<div id="map">より
        map = new google.maps.Map(document.getElementById("map"), opts);

        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(37.693489, 139.486611)
        });

        google.maps.event.addListener(map, 'click', mylistener);
    }

    window.addEventListener("load", function () {
        exec();
        init();
        
        $("#add-button").click(function(){
            if($('#candidate_spots > div').length <= 1){
                sweetAlert("ツアー登録ができませんでした", "ツアーの候補となるスポットが入力されていません", "error");
                return false;
            }
            else if($('#tour_name').val() == ""){
                sweetAlert("ツアー登録ができませんでした", "ツアー名が入力されていません", "error");
                return false;
            }
            else{
                if($('#candidate_spots > div').length > 2)
                    $("#add").submit();
                else
                    sweetAlert("ツアー候補が十分選択されていません", "スポットは２箇所以上選択してください", "error");
            }
        });
        
        $.material.init();
    }, true);

    function mylistener(event) {
        //document.getElementById("show_lat").innerHTML = event.latLng.lat();
        //document.getElementById("show_lng").innerHTML = event.latLng.lng();

        document.getElementById("input_lat").value = event.latLng.lat();
        document.getElementById("input_lng").value = event.latLng.lng();

        marker.position = event.latLng;
        marker.setMap(map);

        readSimilarSpots(event.latLng.lat(),event.latLng.lng());
    }

    function addTableRow(spot_id, spot_name, description, index) {
        
        var rowdata = '<div class="list-group-item">'
            + '<div class="row-action-primary">'
            + '<i class="mdi-content-add btn-primary"></i>'
            + '</div>'
            + '<div class="row-content">'
            //<div class="least-content">15m</div>
            + '<h4 class="list-group-item-heading">' + spot_name + '</h4>'
            + '<p class="list-group-item-text">' + description + '</p>'
            + '</div>'
            + '<div class="list-group-separator"></div>'
            + '</div>';
        
        $('#similar_spots > div:last').after(rowdata);
        $('#similar_spots > div:last > div:first > i').click(function(){
            
            if(document.getElementById('cand_' + spot_id) == null){
                
                var rowdata_candidate = '<div class="list-group-item" id="cand_' + spot_id + '">'
                + '<div class="row-action-primary">'
                + '<label><input type="radio" name="is_goal" value="' + spot_id + '" checked=""> ゴール</label>'
                + '</div>'
                + '<div class="row-content">'
                + '<div class="least-content"><a href="javascript:void(0)" class="btn btn-danger btn-fab btn-raised btn-sm mdi-content-remove" id="rm_cand_' + spot_id + '"></a></div>'
                + '<h4 class="list-group-item-heading">' + spot_name + '</h4><input type="hidden" name="cand_' + spot_id + '" value="' + spot_id + '">'
                + '<p class="list-group-item-text">' + description + '</p>'
                + '</div>'
                + '<div class="list-group-separator"></div>'
                + '</div>'
                
                $('#candidate_spots > div:last').after(rowdata_candidate);
                $('#rm_cand_' + spot_id).click(function(){
                    $('#cand_' + spot_id).remove();
                    
                    if($('#candidate_spots > div').length <= 1)
                        $('#candidate_result').text('候補のスポットが選択されていません');
            
                });
            }
            
            if($('#candidate_spots > div').length > 1)
                $('#candidate_result').text('候補としたスポットの中からツアーのゴールとするスポットを選択してください');
            
        });
    }
    
    function deleteTableRows(){
        var number_rows = $('#similar_spots').children().length;
        
        for(var i = 1; i < number_rows; i++){
            $('#similar_spots > div:last').remove();
        }
    }
    

    function readSimilarSpots(sim_lat, sim_lng) {
        $.ajax({
            type: "GET",
            url: "/manage/readsimilar",
            data: {
                lat : sim_lat,
                lng : sim_lng
            },
            success: function (data) {
                var jsonobj = JSON.parse(data);
                var json_elem;
                
                var message = document.getElementById("search_similar_result");
                if(jsonobj.length > 0)
                    message.innerHTML = "マーカの近隣にスポットが「" + jsonobj.length + "」件見つかりました。";
                else
                    message.innerHTML = "マーカの近隣に登録済のスポットはありませんでした。";
                
                deleteTableRows();
                var index = 1;
                while(jsonobj.length > 0){
                    json_elem = jsonobj.pop();
                    addTableRow(JSON.stringify(json_elem.Spot.id).replace(/"/g,""),
                                JSON.stringify(json_elem.Spot.name).replace(/"/g,""),
                                JSON.stringify(json_elem.Spot.description).replace(/"/g,""),
                                index)
                    index++;
                }
                
            },
            error: function () {
                sweetAlert("近隣スポットを読み出せませんでした", "DBアクセスに失敗しました", "error");
            }
        });
        return true
    }
    
    
</script>

<script src="/js/app/manage/index.js"></script>
<div class="container">

    <div style="text-align;center">
        <h3>ユーザに散歩してほしいコースをツアーとして登録しましょう</h3>
        <h4>ユーザに立ち寄って欲しいスポットを選択してください</h4>
    </div>
    <br>


        <div class="panel panel-info">
            <div class="panel-heading"><i class="mdi-maps-place"></i>　ツアーの候補とした場所を地図で選択してください</div>
            <div class="panel-body">
                <div id="map" style="height:400px"></div>
                <!--
                <p>緯度</p>
                <p id="show_lat"></p>
                <p>経度</p>
                <p id="show_lng"></p>
                -->
            </div>
            <div class="container">
                <div class="row">
                   
                    
                </div>
            </div>
        </div>

    <form method="post" enctype="multipart/form-data" action="/manage/addtourresult" id="add">
        <div class="row">
            <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="mdi-maps-pin-drop"></i>　地図で選んだ地点の近隣にあるスポットを選択してください</div>
                <div class="panel-body">
                    <p id=search_similar_result></p>
                    <!-- <table class="table table-striped" id="similar_spots">
                        <tr>
                            <th>#</th>
                            <th>スポット名</th>
                        </tr>
                    </table>-->
                    <div class="list-group" id="similar_spots">
                        <div class="list-group-item">
                        </div>
                    </div>
                </div>
            </div>
            </div>

        <div class="col-md-6">

                <div class="panel panel-info" id="about-info">
                    <div class="panel-heading"><i class="mdi-navigation-check"></i>　ツアー登録候補として選択したスポット</div>
                    <div class="panel-body">
                        <p id=candidate_result>候補のスポットが選択されていません</p>
                        <div class="list-group" id="candidate_spots">
                            <div class="list-group-item">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
            
        <div class="col-md-12">
            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><i class="mdi-editor-mode-edit"></i>　ツアーにつける名前を入力してください</div>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="tour_name" id="tour_name" style="width:100%;" placeholder="ツアー名を入力してください">
                    </div>
            </div>
        </div>
            
        <div class="col-md-12">
            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><i class="mdi-editor-mode-edit"></i>　ツアーの説明を入力してください</div>
                    <div class="panel-body">
                        <textarea class="form-control" name="tour_description" id="tour_description" style="width:100%;" placeholder="ツアーの説明を入力してください" rows="4"></textarea>
                    </div>
            </div>
        </div>
        </div>
        
        <input type="hidden" id="input_lat"/>
        <input type="hidden" id="input_lng"/>
    </form>
    
    <div style="text-align:center;">
        <a class="btn btn-info btn-lg" style="width:100%;" id="add-button">登録する</a>
    </div>
</div>
