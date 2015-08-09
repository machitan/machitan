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
       
        $("#del-button").click(function(){
            if($('#similar_spots > div').length <= 1){
                sweetAlert("スポットを削除できませんでした", "削除するスポットが選択されていません", "error");
                return false;
            }
            else{
                var flag = false;
                for(var i=0; i <= $('#similar_spots > div').length; i++){
                    if($('#del_check'+i).prop('checked')){
                        flag = true;
                    }
                }
                if(flag){
                    add=$("#del").submit();
                }else{
                    sweetAlert("スポットを削除できませんでした", "削除するスポットが選択されていません", "error");
                    return false;
                }
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
            + '<input type="checkbox" id="del_check'+index+'" name="del_check'+index+'" value="' + spot_id +'"/>'
            + '</div>'
            + '<div class="row-content">'
            + '<h4 class="list-group-item-heading">' + spot_name + '</h4>'
            + '<p class="list-group-item-text">' + description + '</p>'
            + '</div>'
            + '<div class="list-group-separator"></div>'
            + '</div>';
        
        $('#similar_spots > div:last').after(rowdata);
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
                $('#del_num').val(index-1);
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
        <h4>スポットを削除します</h4>
    </div>
    <br>


        <div class="panel panel-info">
            <div class="panel-heading"><i class="mdi-maps-place"></i>　削除したいスポット付近を地図で選択してください</div>
            <div class="panel-body">
                <div id="map" style="height:400px"></div>
            </div>
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>

    <form method="post" enctype="multipart/form-data" action="/manage/delspotresult" id="del">
        <div style="text-align:center;">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="mdi-maps-pin-drop"></i>　削除したいスポットを選択してください</div>
                <div class="panel-body">
                    <p id=search_similar_result></p>
                    <div class="list-group" id="similar_spots">
                        <div class="list-group-item">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="input_lat"/>
        <input type="hidden" id="input_lng"/>
        <input type="hidden" name="del_num" id="del_num" value="0"/>
    </form>
    
    <div style="text-align:center;">
        <a class="btn btn-info btn-lg" style="width:100%;" id="del-button">削除する</a>
    </div>
</div>
