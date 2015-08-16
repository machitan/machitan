var lat = null;
var lng = null;

function setGeoInfoInput(){
    // フォームのパラメータに現在地情報を追加
    var latdiv='<input type="hidden" name="lat" value="' + lat + '"/>'
    var lngdiv='<input type="hidden" name="lng" value="' + lng + '"/>'
    $('#hiddenpost > input:last').after(latdiv);
    $('#hiddenpost > input:last').after(lngdiv);
}

$(function(){

	if(navigator.geolocation) {
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
                sweetAlert("GPSをOnにしてください");
        });
	} else {
	  lat = 36.562127;
	  lng = 136.662458;
      sweetAlert("GPSをOnにしてください");
    }

    $('a').click(function(){
        // リンクに現在地情報を付与
        var href = $(this).attr('href');
        if (href.lastIndexOf('/list', 0) === 0) {
            href += "&lat=" + lat + "&lng=" + lng;
            $(this).attr('href', href);
            return true;
        }else {
            location.href(href);
            return false;
        }
      });

    setTimeout('setGeoInfoInput();', 500);

});
