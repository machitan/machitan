<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0" />
<script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript" charset="UTF-8"></script>

<script>
//兼六園
    var lat = 36.562127;
    var lng = 136.662458;
//神奈川県庁
//    var lat = 35.448086;
//    var lng = 139.642146;

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

    window.addEventListener("load", function () {
        exec();
        init();

        if (!window.File) {
            result.innerHTML = "File API 使用不可";
            return;
        }

        document.getElementById("imageFile").addEventListener("change", function () {
            var reader = new FileReader();

            reader.onload = function (event) {
                document.getElementById("image").src = reader.result;
            }
            var file = document.getElementById("imageFile").files[0];
            reader.readAsDataURL(file);
        }, true);
    }, true);

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

    function mylistener(event) {
        //document.getElementById("show_lat").innerHTML = event.latLng.lat();
        //document.getElementById("show_lng").innerHTML = event.latLng.lng();

        document.getElementById("input_lat").value = event.latLng.lat();
        document.getElementById("input_lng").value = event.latLng.lng();

        marker.position = event.latLng;
        marker.setMap(map);

        readSimilarSpots(event.latLng.lat(),event.latLng.lng());
    }

    var counter = 0;

    function addTableRow(spot_id, spot_name, spot_description,index) {
        counter++;
        var table1 = document.getElementById("similar_spots");
        var row1 = table1.insertRow(counter);
        var cell1 = row1.insertCell(0);
        var cell2 = row1.insertCell(1);
        var cell3 = row1.insertCell(2);
        
        cell1.innerHTML = '<input type="checkbox" name="chk_' + index + '" value="' + spot_id + '" />';
        cell2.innerHTML = spot_name;
        cell3.innerHTML = spot_description.substring(1,30) + "...";
    }
    
    function deleteTableRows(){
        var table1 = document.getElementById("similar_spots");
        
        while(counter > 0){
            table1.deleteRow(counter);
            counter--;
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
                    message.innerHTML = "近隣のスポットが「" + jsonobj.length + "」件見つかりました。";
                else
                    message.innerHTML = "近隣に登録済のスポットはありませんでした。";
                
                deleteTableRows();
                var index = 1;
                while(jsonobj.length > 0){
                    json_elem = jsonobj.pop();
                    addTableRow(JSON.stringify(json_elem.Spot.id),JSON.stringify(json_elem.Spot.name),JSON.stringify(json_elem.Spot.description),index)
                    index++;
                }
                
            },
            error: function () {
                alert('error');
            }
        });
        return true
    }
</script>

<script src="/js/app/manage/index.js"></script>
<div class="container">

    <div style="text-align;center">
        <h4>あなたの見つけたお気に入りのスポットを登録しよう！</h4>
    </div>
    <br>

    <form method="post" enctype="multipart/form-data" action="add" id="add">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　あなたの撮ったまちの写真（必須）</div>
            <div class="panel-body">
                <img id="image" width="100%">
                <input type="file" accept="image/*;capture=camera" id="imageFile" name="picture" />
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットのお名前を入力してください（必須）</div>
            <div class="panel-body">
                <input type="text" id="name" name="name" style="width:100%" class="form-control" required>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>カテゴリを選択してください</div>
            <div class="panel-body">
                <select class="selectpicker form-control" name="category_id" class="form-control">
                    <option value="1">食べる</option>
                    <option value="2">買う</option>
                    <option value="3">遊ぶ</option>
                    <option value="4">その他</option>
                </select>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットの説明を入力してください</div>
            <div class="panel-body">
                <textarea id="description" name="description" style="width:100%" class="form-control"></textarea>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　お店の場所を地図で選択してください</div>
            <div class="panel-body">
                <div id="map" style="height:400px"></div>
                <!--
                <p>緯度</p>
                <p id="show_lat"></p>
                <p>経度</p>
                <p id="show_lng"></p>
                -->
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　こちらのスポットは既に登録されていませんか？</div>
            <div class="panel-body">
                <p>まちたん！ユーザが既に登録していれば、そのスポット情報をチェックしてください。</p>
                <p>チェックいただいたスポット情報より、ご登録いただいた情報を優先的に表示いたします。</p>
                <p id=search_similar_result></p>
                <table class="table table-striped" id="similar_spots">
                    <tr>
                        <th>#</th>
                        <th>スポット名</th>
                        <th>スポット説明</th>
                    </tr>
                </table>
            </div>
        </div>


        <p>
            <input type="submit" value="登録" class="btn btn-primary btn-block btn-lg">
        </p>
        <input type="hidden" name="direction_id" value="<?php echo $direction_id?>">
        <input type="hidden" name="step_id" value="<?php echo $step_id?>">
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id?>">
        <input type="hidden" name="lat" value="0" id="input_lat">
        <input type="hidden" name="lng" value="0" id="input_lng">

    </form>
</div>
