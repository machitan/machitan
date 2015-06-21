$(function(){

  var lat = null;
  var lng = null;

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
        sweetAlert("GPSをOnにしてください");
      });
	} else {
	  lat = 36.562127;
	  lng = 136.662458;
    alert("GPSをOnにしてください");
  }

  $('a').click(function(){

    // リンクに現在地情報を付与
    var href = $(this).attr('href');
    href += "&lat=" + lat + "&lng=" + lng;
    $(this).attr('href', href);

    return true;
  });

});
	
